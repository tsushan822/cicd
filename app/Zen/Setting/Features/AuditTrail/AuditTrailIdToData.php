<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 29/05/2018
 * Time: 14.50
 */

namespace App\Zen\Setting\Features\AuditTrail;

use App\Exceptions\CustomException;
use App\Zen\Setting\Model\Account;
use App\Zen\Lease\Model\LeaseType;
use App\Zen\Setting\Model\CostCenter;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\Portfolio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

trait AuditTrailIdToData
{

    public function idToRealData($foreignColumnName, $id)
    {
        if(!$id)
            return $id;

        if(is_array($id)) {
            $returnArray = [];
            foreach($id as $value) {
                $returnArray[] = $this -> convertingIdToRealData($foreignColumnName, $value);
            }
            return $returnArray;
        }

        return $this -> convertingIdToRealData($foreignColumnName, $id);

    }

    /**
     * @param $foreignKey
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws CustomException
     */
    public function makeModel($foreignKey)
    {
        $app = new App();
        $model = $app -> make($this -> model($foreignKey));

        if(!$model instanceof Model)
            throw new CustomException("Class {$this->model($foreignKey)} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this -> model = $model -> newQuery();
    }

    public function columnNameToConvert()
    {
        return [
            ['foreign_key' => 'currency_id', 'value' => 'iso_4217_code'],
            ['foreign_key' => 'lease_type_id', 'value' => 'type'],
            ['foreign_key' => 'entity_id', 'value' => 'short_name'],
            ['foreign_key' => 'counterparty_id', 'value' => 'short_name'],
            ['foreign_key' => 'cost_center_id', 'value' => 'short_name'],
            ['foreign_key' => 'account_id', 'value' => 'account_name'],
            ['foreign_key' => 'portfolio_id', 'value' => 'name'],
            ['foreign_key' => 'counterparty_account_id', 'value' => 'account_name'],
        ];
    }

    /**
     * @param $foreignKey
     * @return string
     * @throws CustomException
     */
    public function model($foreignKey)
    {
        switch($foreignKey){
            case 'currency_id':
                return Currency::class;
                break;

            case 'lease_type_id':
                return LeaseType::class;
                break;

            case 'entity_id':
                return Counterparty::class;
                break;

            case 'counterparty_id':
                return Counterparty::class;
                break;

            case 'cost_center_id':
                return CostCenter::class;
                break;

            case 'portfolio_id':
                return Portfolio::class;
                break;

            case 'account_id':
            case 'entity_account_id':
            case 'counterparty_account_id':
                return Account::class;
                break;

            default:
                throw new CustomException(trans("master.No class defined for this class"));
                break;
        }
    }

    public function getName()
    {
        return [
            'currency_id' => 'Currency',
            'entity_id' => 'Entity',
            'counterparty_id' => 'Counterparty',
            'account_id' => 'Account',
            'portfolio_id' => 'Portfolio',
            'cost_center_id' => 'Cost Center',
            'lease_type_id' => 'Lease Type',
        ];
    }

    public function modifyModelName($model)
    {
        $change = [
            'Lease' => 'Leasing',
        ];
        return array_key_exists($model, $change) ? $change[$model] : $model;
    }

    /**
     * @param $foreignColumnName
     * @param $id
     * @return mixed|string
     */
    public function convertingIdToRealData($foreignColumnName, $id)
    {
        $array = $this -> columnNameToConvert();
        $newArray = array_column($array, 'foreign_key');
        $arrayNumber = array_search($foreignColumnName, $newArray);
        $valueColumn = $array[$arrayNumber]['value'];
        $modelName = $this -> makeModel($foreignColumnName);
        $data = $modelName -> find($id);
        if(!$data) {
            return 'Does not exist';
        }
        return $data -> $valueColumn;
    }
}