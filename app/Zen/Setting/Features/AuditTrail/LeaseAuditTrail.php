<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 30/05/2018
 * Time: 15.39
 */

namespace App\Zen\Setting\Features\AuditTrail;

use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Model\LeaseFlow;

class LeaseAuditTrail extends AuditTrailDataConvert
{

    protected $id;

    public function finalData($id)
    {

        $leaseAuditTrails = $this -> getLeaseAuditTrails($id);

        $leaseFlowAuditTrails = $this -> getLeaseFlowAuditTrail($id);

        $leaseExtensionAuditTrails = $this -> getLeaseExtensionAuditTrail($id);

        $returnArray = array_merge($leaseFlowAuditTrails, $leaseExtensionAuditTrails, $leaseAuditTrails);

        return $this -> sortReturnArray($returnArray);
    }

    /**
     * Get audit trail for given lease
     * @param $id
     * @return array
     */
    public function getLeaseAuditTrails($id)
    {
        $this -> setId($id);

        $leaseAuditTrails = $this -> getAuditTrailData('Lease', $id);

        $leaseAuditTrails = $this -> decryptDataForAuditTrail($leaseAuditTrails, (new Lease()) -> encryptable);

        return $leaseAuditTrails;
    }

    /**
     * Get audit trail of lease flow for given lease
     * @param $id
     * @return array
     */
    public function getLeaseFlowAuditTrail($id)
    {
        $leaseFlowAuditTrails = [];

        $leaseFlows = LeaseFlow ::where('lease_id', $id) -> get();

        foreach($leaseFlows as $leaseFlow)
            $leaseFlowAuditTrails = array_merge($leaseFlowAuditTrails, (new LeaseFlowAuditTrail()) -> finalData($leaseFlow -> id));

        return $leaseFlowAuditTrails;

    }

    /**
     * Get audit trail of lease flow for given lease
     * @param $id
     * @return array
     */
    public function getLeaseExtensionAuditTrail($id)
    {
        $leaseExtensionAuditTrails = [];

        $leaseExtensions = LeaseExtension ::where('lease_id', $id) -> withTrashed() -> get();
        foreach($leaseExtensions as $leaseExtension)
            $leaseExtensionAuditTrails = array_merge($leaseExtensionAuditTrails, (new LeaseExtensionAuditTrail()) -> finalData($leaseExtension -> id));

        return $leaseExtensionAuditTrails;

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this -> id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this -> id = $id;
    }
}