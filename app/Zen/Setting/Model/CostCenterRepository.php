<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 26/10/2017
 * Time: 15.53
 */

namespace App\Zen\Setting\Model;
;

use App\Repository\Eloquent\Repository;
use App\Zen\Lease\Model\LeaseType;
use App\Zen\Setting\Features\Import\Upload\CostCenterUpload;
use App\Zen\Setting\Features\Import\Upload\SecurityUpload;
use Illuminate\Support\Facades\Auth;

class CostCenterRepository extends Repository
{
    public function model()
    {
        return CostCenter::class;
    }

    public function getCreateViewData()
    {
        $portfolios = Portfolio ::get() -> pluck('name', 'id') -> toArray();
        asort($portfolios);
        return array($portfolios);

    }

    /**
     * @param $request
     * @return mixed
     */
    public function handleCreate($request)
    {
        $request -> request -> add(['user_id' => Auth ::id()]);
        return $this -> create($request -> all());
    }

    /**
     * @param $request
     * @return mixed
     */
    public function handleEdit($request, $id)
    {
        $request -> request -> add(['updated_user_id' => Auth ::id()]);
        return $this -> find($id) -> update($request -> all());
    }

    public function handleImport()
    {
        $file = request() -> file('costcenter_excel');

        list($extension, $numberOfUploads) = (new CostCenterUpload()) -> uploadToDatabase($file);

        flash() -> overlay($numberOfUploads . ' costcenter(s) are imported from ' . $extension . ' file') -> message();
    }

    public function checkDeletable(int $id)
    {
        $costCenter = CostCenter ::with( 'leases') -> findOrFail($id);
        return count($costCenter -> leases);
    }

}