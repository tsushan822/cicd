<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 08/10/2018
 * Time: 11.55
 */

namespace App\Zen\Setting\Features\AuditTrail;



class LeaseExtensionAuditTrail extends AuditTrailDataConvert
{

    private $includePrefix = true;

    public function finalData($id)
    {
        $data = $this -> getAuditTrailDataAll('LeaseExtension', $id, $this -> includePrefix);

        $data = $this -> decryptDataForAuditTrail($data, 'LeaseExtension');

        return $data;
    }

    /**
     * @param bool $includePrefix
     * @return LeaseExtensionAuditTrail
     */
    public function setIncludePrefix(bool $includePrefix): LeaseExtensionAuditTrail
    {
        $this -> includePrefix = $includePrefix;
        return $this;
    }
}