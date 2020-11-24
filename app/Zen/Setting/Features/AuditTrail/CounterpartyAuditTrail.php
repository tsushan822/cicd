<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 30/05/2018
 * Time: 16.50
 */

namespace App\Zen\Setting\Features\AuditTrail;


use App\Zen\Setting\Model\Counterparty;

class CounterpartyAuditTrail extends AuditTrailDataConvert
{
    public function finalData($id)
    {
        $data = $this -> getAuditTrailData('Counterparty', $id);
        $data = $this -> decryptDataForAuditTrail($data, (new Counterparty()) -> encryptable);
        return $data;
    }
}