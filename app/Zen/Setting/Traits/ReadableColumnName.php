<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 01/12/2017
 * Time: 15.39
 */

namespace App\Zen\Setting\Traits;


trait ReadableColumnName
{
    public function getReadableData($table)
    {
        return [
            'trade_date' => 'Trade Date',
            'notional_currency_amount' => 'Notional Currency Amount',
            'cross_currency_amount' => 'Cross Currency Amount',
            'non_accountable' => 'Excluded from Accounting and Reporting',
        ];
    }
}