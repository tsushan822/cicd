<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 04/10/2018
 * Time: 13.40
 */

namespace App\Zen\Setting\Update\FxRate;

use App\Zen\System\Model\MainCurrency;
use App\Zen\System\Model\MainFx;
use App\Zen\System\Traits\ConfigDatabase;

abstract class UpdateFxRate
{
    use ConfigDatabase;

    protected $output;
    protected $date;
    protected $currencies;
    protected $existingRatesForDate;

    public function __construct()
    {
        $this -> output = $this -> getSource();

        $this -> date = $this -> getDate();

    }

    abstract function getSource();

    abstract function getData();

    public function update()
    {

        $this -> setCurrencies();

        $this -> setExistingRatesForDate();

        $this -> getData();

    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this -> date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this -> date = $date;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this -> output;
    }

    /**
     * @param mixed $output
     */
    public function setOutput($output)
    {
        $this -> output = $output;
    }

    /**
     * @return mixed
     */
    public function getCurrencies()
    {
        return $this -> currencies;
    }

    /**
     * @return $this
     */
    public function setCurrencies()
    {
        $this -> currencies = MainCurrency :: pluck('iso_4217_code', 'id') -> toArray();
        return $this;
    }

}