<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 19/04/2018
 * Time: 12.58
 */

namespace App\Zen\Lease\Model;


use App\Events\Lease\LeaseChangeDelete;
use App\Exceptions\CustomException;
use App\Repository\Eloquent\FreezeRepository;
use App\Scopes\LeaseAccountableScope;
use App\Zen\Setting\Model\Account;
use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\LeaseEditView;
use App\Zen\Lease\Calculate\Request\LeaseExtensionRequest;
use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Setting\Calculate\DateTime\GetData;
use App\Zen\Setting\Model\CostCenter;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\Portfolio;
use App\Zen\System\File\Document;
use App\Zen\System\Service\ModuleAvailabilityService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaseRepository extends FreezeRepository
{

    /**
     * Specify Model class name
     * @return mixed
     */
    public function model()
    {
        return Lease::class;
    }

    public function getCreateViewData()
    {
        $entities = Counterparty ::entity() -> allowedEntity() -> get() -> pluck('short_name', 'id') -> toArray();
        asort($entities);

        $paymentDays = GetData ::getAllPaymentDays();

        $counterparties = Counterparty ::counterparty() -> get() -> pluck('short_name', 'id') -> toArray();
        asort($counterparties);

        $currencies = Currency ::active() -> pluck('iso_4217_code', 'id');

        $accounts = Account :: orderBy('account_name') -> get() -> pluck('account_name', 'id');

        $portfolios = Portfolio ::orderBy('name') -> get() -> pluck('name', 'id');

        $costCenters = CostCenter :: get() -> pluck('short_name', 'id') -> toArray();
        asort($costCenters);

        $leaseTypes = LeaseType :: get() -> pluck('type', 'id');

        $costCenterSplits = $this -> costCenterSplits(null, false);

        $buttonShow['add'] = $this -> addNewButtonWithDateFreeze('create_lease');
        $buttonShow['cost_center_split'] = app('costCenterSplitAdmin');
        $buttonShow['cost_center'] = true;
        $buttonShow['audit_trail'] = false;
        $buttonShow['attachments'] = false;

        return array($entities, $counterparties, $costCenters, $currencies, $accounts,
            $portfolios, $leaseTypes, $paymentDays, $buttonShow, $costCenterSplits);
    }

    public function getEditViewData($lease)
    {

        $this -> checkIfAllowedForThisEntity($lease -> entity_id);
        $entities = Counterparty ::entity() -> allowedEntity() -> get() -> pluck('short_name', 'id') -> toArray();
        asort($entities);

        $paymentDays = GetData ::getAllPaymentDays();

        $counterparties = Counterparty ::counterparty() -> get() -> pluck('short_name', 'id') -> toArray();
        asort($counterparties);

        $currencies = Currency ::active() -> pluck('iso_4217_code', 'id');

        $accounts = Account :: where('currency_id', $lease -> currency_id) -> orderBy('account_name') -> get() -> pluck('account_name', 'id');

        $portfolios = Portfolio ::orderBy('name') -> get() -> pluck('name', 'id');

        $costCenters = CostCenter :: get() -> pluck('short_name', 'id') -> toArray();
        asort($costCenters);

        $leaseTypes = LeaseType :: get() -> pluck('type', 'id');

        $leaseFlows = LeaseFlowService ::leaseFlowsAll($lease);

        $costCenterSplits = $this -> costCenterSplits($lease);

        //To split the extension view
        $previousExtension = 0;
        $subscript = 0;
        foreach($leaseFlows as $leaseFlow) {
            if($previousExtension !== $leaseFlow -> lease_extension_id) {
                $leaseFlowAdd = new LeaseFlow();
                $leaseFlowAdd -> cssClass = "extension_heading";
                if($leaseFlow -> leaseExtension == null)
                    throw new CustomException('There is a problem in the lease flow ', ['leaseFlowId' => $leaseFlow -> id]);
                $leaseFlowAdd -> start_date = $leaseFlow -> leaseExtension -> date_of_change;
                $leaseFlowAdd -> liability_opening_balance = $leaseFlow -> liability_opening_balance;
                $leaseFlowAdd -> depreciation_opening_balance = $leaseFlow -> depreciation_opening_balance;
                $leaseFlows -> splice($subscript, 0, [$leaseFlowAdd]);
                $subscript++;
            }
            $previousExtension = $leaseFlow -> lease_extension_id;
            $subscript++;
        }

        $leaseExtensions = LeaseExtension ::where('lease_id', $lease -> id) -> get();
        $disabled['single'] = false;
        $disabled['double'] = false;
        if(count($leaseExtensions) == 1) {
            $disabled['single'] = true;
        }
        if(count($leaseExtensions) > 1) {
            $disabled['single'] = true;
            $disabled['double'] = true;
        }

        $files = Document ::setModel($lease) -> listFiles();

        $buttonShow['action'] = $this -> actionButtonWithDateFreeze($lease -> effective_date, 'edit_lease_flow');
        $buttonShow['delete'] = $this -> deleteButtonWithDateFreeze($lease -> effective_date, 'delete_lease');
        $buttonShow['delete_ext'] = count($leaseExtensions) ? $this -> deleteExtButtonWithDateFreeze($leaseExtensions[count($leaseExtensions) - 1] -> extension_start_date, 'delete_lease') : true;
        $buttonShow['save'] = $this -> saveButtonWithDateFreeze($lease -> effective_date, 'edit_lease');
        $buttonShow['clear_all'] = $this -> clearAllButtonWithDateFreeze($lease -> effective_date, 'delete_lease_flow');
        $buttonShow['copy'] = $this -> copyButtonWithDateFreeze('create_lease');
        $buttonShow['add'] = $this -> addNewButtonWithDateFreeze('create_lease');
        $buttonShow['cost_center_split'] = app('costCenterSplitAdmin');
        $buttonShow['cost_center'] = !app('costCenterSplitAdmin') || !$lease -> cost_center_split;
        $buttonShow['audit_trail'] = ModuleAvailabilityService ::checkAuditTrailAvailability();
        $buttonShow['attachments'] = ModuleAvailabilityService ::checkAttachmentsAvailability();
        $buttonShow['facility_overview'] = ModuleAvailabilityService ::checkFacilityOverviewAvailability();

        return array($entities, $counterparties, $costCenters, $currencies, $accounts, $portfolios, $leaseTypes,
            $leaseFlows, $leaseExtensions, $disabled, $files, $paymentDays, $buttonShow, $costCenterSplits);
    }

    public function handleCreate($request)
    {
        $request -> request -> add(['user_id' => Auth ::id()]);
        $lease = $this -> create($request -> all());
        flash() -> overlay(trans('master.New Lease Created'), trans('master.Created!')) -> message();
        return $lease;
    }

    public function handleEdit($request, $id)
    {
        $lease = $this -> findWithoutScope($id);
        $this -> checkIfAllowedForThisEntity($lease -> entity_id);

        $request -> request -> add(['updated_user_id' => Auth ::id()]);
        if($request -> hasFile('document_file')) {
            Document ::setModel($lease) -> upload($request -> file('document_file'));
        }
        $lease -> update($request -> all());

        $this -> costCenterSplitAdd($lease, $request);

        if($request -> lease_extension) {
            LeaseExtensionRequest ::leaseExtension($request, $lease);
        }

        flash() -> overlay(trans('master.Lease Updated'), trans('master.Success!')) -> message();
        return $lease;
    }

    public function deleteExtension($leaseExtensionId)
    {
        //Find Lease Extension
        $leaseExtension = LeaseExtension ::findOrFail($leaseExtensionId);

        //Get lease of that extension
        $lease = $leaseExtension -> lease;

        //Force Delete all lease flows associate with that extension
        LeaseFlow ::where('lease_extension_id', $leaseExtensionId) -> forcedelete();

        //Delete the extension
        LeaseExtension ::findOrFail($leaseExtensionId) -> forcedelete();

        event(new LeaseChangeDelete($lease, $leaseExtensionId));

        //get last deleted lease flow
        $lastDeletedFlow = LeaseFlow ::onlyTrashed() -> orderBy('deleted_at', 'desc') -> where('lease_id', $lease -> id) -> first();
        if($lastDeletedFlow) {
            $leaseExtension = LeaseExtension ::where('lease_id', $lease -> id) -> get();
            if(count($leaseExtension)) {
                $update = LeaseFlow ::onlyTrashed() -> where('deleted_at', $lastDeletedFlow -> deleted_at) -> restore();
                (new LeaseEditView($lease)) -> updateDepreciation();
            }
        }
    }

    public function findWithoutScope($leaseId)
    {
        $lease = Lease ::withoutGlobalScope(LeaseAccountableScope::class) -> findOrFail($leaseId);
        return $lease;
    }

    public function handleImport()
    {
        $file = request() -> file('lease_excel');

        list($extension, $numberOfUploads) = (new LeaseUpload()) -> uploadToDatabase($file);

        flash() -> overlay($numberOfUploads . ' lease(s) are imported from ' . $extension . ' file') -> message();
    }

    private function costCenterSplitAdd($lease, $request)
    {
        $addArray = [];
        if($lease -> cost_center_split && is_array($request -> cost_center_split_id)) {
            foreach($request -> cost_center_split_id as $key => $value) {
                if(!empty($request -> percentage[$key]))
                    $addArray[$key] = ['percentage' => $request -> percentage[$key]];
            }

            $lease -> costCenters() -> sync($addArray);
        }
    }

    private function costCenterSplits($lease = null, $edit = true)
    {
        $costCenters = CostCenter ::all();

        foreach($costCenters as $costCenter) {
            if($edit && !is_null($lease)) {
                $exists = DB ::table('cost_center_lease')
                    -> whereCostCenterId($costCenter -> id)
                    -> whereLeaseId($lease -> id) -> get();
                $costCenter -> exists = count($exists) ? true : false;
                $costCenter -> percentage = count($exists) ? $exists[0] -> percentage : null;
            } else {
                $costCenter -> exists = false;
            }

        }

        return $costCenters;

    }
}