<?php


namespace App\Zen\Setting\Service;


use App\Events\System\ExecuteCommandEvent;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\FxRate;
use App\Zen\System\Model\Customer;
use App\Zen\System\Model\ExecuteCommand;
use App\Zen\System\Model\MainFx;
use Illuminate\Support\Facades\Log;

class FxRateImportService
{

    protected $customer;
    protected $date;
    protected $currencies;
    const COMMAND_TYPE = 'fx-rate';

    public function __construct(Customer $customer)
    {
        $this -> customer = $customer;
        $this -> getCurrencies();
        $this -> setDate(today() -> subDay() -> toDateString());
    }

    /**
     * @param mixed $date
     * @return FxRateImportService
     */
    public function setDate($date)
    {
        $this -> date = $date;
        return $this;
    }

    public function getIdFromIso4217CodeInCustomerDatabase($iso4217Code)
    {
        return $this -> currencies[$iso4217Code];
    }

    function getCurrencies()
    {
        $this -> currencies = Currency ::active() -> pluck('id', 'iso_4217_code') -> toArray();
    }

    /**
     * @param string $today
     */
    public function updateFromMainDatabase(string $today): void
    {
        $rates = MainFx ::where('source', $this -> customer -> fx_rate_source) -> where('date', $today) -> get();

        foreach($rates as $rate) {
            if(!in_array($rate -> crossCurrency -> iso_4217_code, $this -> currencies))
                continue;
            try {
                $baseCurrency = $this -> getIdFromIso4217CodeInCustomerDatabase($rate -> baseCurrency -> iso_4217_code);
                $crossCurrency = $this -> getIdFromIso4217CodeInCustomerDatabase($rate -> crossCurrency -> iso_4217_code);
                FxRate ::updateOrCreate(['ccy_base_id' => $baseCurrency, 'ccy_cross_id' => $crossCurrency, 'date' => $rate -> date, 'direct_quote' => $rate -> direct_quote],
                    ['rate_bid' => $rate -> rate_bid, 'user_id' => 1]
                );
            } catch (\Exception $e) {
                echo $e -> getMessage();
            }
        }
        $this -> commandExecuted(true, now());
    }

    public function updateFromDataBond()
    {
        $response = DataBondService ::dataBondLogin();
        $bearerToken = json_decode($response) -> data;
        $value = (new DataBondService) -> setBearerToken($bearerToken) -> getDataBondLatestRate($this -> customer -> databond_client_id);

        $returnedValueInArray = json_decode($value -> getContents(), true);

        $date = $returnedValueInArray['data']['fx_rates'][0]['date'];
        $this -> setDate($date);

        if($this -> checkIfCommandExecuted()) {
            return;
        }

        foreach($returnedValueInArray['data']['fx_rates'][0]['data'] as $rate) {
            if(is_array($rate) && array_key_exists($rate['cross_currency'], $this -> currencies) && array_key_exists($rate['base_currency'], $this -> currencies)) {
                try {
                    $baseCurrency = $this -> getIdFromIso4217CodeInCustomerDatabase($rate['base_currency']);
                    $crossCurrency = $this -> getIdFromIso4217CodeInCustomerDatabase($rate['cross_currency']);

                    FxRate ::updateOrCreate(['ccy_base_id' => $baseCurrency, 'ccy_cross_id' => $crossCurrency, 'date' => $this -> date, 'direct_quote' => 1],
                        ['rate_bid' => $rate['rate_bid'], 'source' => 'Databond']
                    );
                } catch (\Exception $e) {
                    Log ::critical('Update from databond failed for: ' . $this -> customer -> name . '. Reason: ' . $e -> getMessage());
                }
            }


        }
        $this -> commandExecuted(true, now() -> toDateString());

    }

    public function commandExecuted(bool $done = true, string $endedAt = null)
    {
        $attr = [
            'date_to_run' => $this -> date,
            'command_type' => self::COMMAND_TYPE,
            'customer_id' => $this -> customer -> id,
            'started_at' => now(),
            'ended_at' => $endedAt,
            'done' => $done
        ];
        event(new ExecuteCommandEvent($attr));
    }

    private function checkIfCommandExecuted()
    {
        return ExecuteCommand ::where('date_to_run', $this -> date) -> where('command_type', self::COMMAND_TYPE) -> where('customer_id', $this -> customer -> id) -> where('done', 1) -> first();
    }

}