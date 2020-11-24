<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 25/09/2018
 * Time: 10.34
 */

namespace App\Zen\Setting\Features\AuditTrail;


use App\Zen\Lease\Model\LeaseFlow;

class LeaseFlowAuditTrail extends AuditTrailDataConvert
{
    private $includePrefix = true;

    public function finalData($id)
    {

        $data = $this -> getAuditTrailDataAll('LeaseFlow', $id , $this->includePrefix);

        //$data = $this -> decryptDataForAuditTrail($data, (new LeaseFlow()) -> encryptable);

        return $data;
    }

    /**
     * @param bool $includePrefix
     * @return LeaseFlowAuditTrail
     */
    public function setIncludePrefix(bool $includePrefix): LeaseFlowAuditTrail
    {
        $this -> includePrefix = $includePrefix;
        return $this;
    }

}