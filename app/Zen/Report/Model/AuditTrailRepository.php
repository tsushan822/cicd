<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 25/09/2018
 * Time: 15.38
 */

namespace App\Zen\Report\Model;

use App\Zen\Setting\Features\AuditTrail\AuditTrailDataConvert;
use App\Zen\Setting\Model\AuditTrail;

class AuditTrailRepository extends AuditTrailDataConvert
{
    public function auditTrailQuery($startDate, $endDate, $request)
    {
        $query = AuditTrail :: with('user') -> whereBetween('created_at', [$startDate, $endDate]);

        if($request -> user_id) {
            $query = $query -> where('user_id', $request -> user_id);
        }

        if($request -> model) {
            $query = $this -> filterModel($request, $query);
        }
        return $query -> get();

    }

    public function filterModel($request, $query)
    {
        switch($request -> model){
            case 'MmDeal':
                $query -> where(function ($query) {
                    $query -> where('model', 'DealFlow') -> orWhere('model', 'MmDeal') -> orWhere('model', 'InterestFlow');
                });
                break;
            case 'Lease':
                $query -> where(function ($query) {
                    $query -> where('model', 'LeaseFlow') -> orWhere('model', 'Lease') -> orWhere('model', 'LeaseExtension');
                });
                break;
            case 'Guarantee':
            case 'FxDeal':
                $query -> where('model', $request -> model);
                break;
            default:
                break;
        }

        return $query;
    }

    public function finalData($id)
    {
        //
    }

    public function getFinalData($auditTrails)
    {
        $auditTrails = $this -> getAuditTrailDataFunction($auditTrails);
        return $this -> decryptDataForAuditTrail($auditTrails, $this -> listOfEncryptable());
    }

    public function listOfEncryptable()
    {
        return ['text', 'long_name', 'postal_address1', 'postal_address2', 'client_account_name', 'business_area',
            'functional_area', 'guarantee_name', 'beneficiary', 'project_name', 'terms_of_conditions',
            'reference_internal', 'reference_external', 'IBAN', 'BIC', 'bank', 'town'];
    }

}
