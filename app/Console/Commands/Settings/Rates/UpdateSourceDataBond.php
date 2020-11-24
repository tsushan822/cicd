<?php

namespace App\Console\Commands\Settings\Rates;

use App\Zen\Setting\Service\DataBondService;
use App\Zen\System\Model\Customer;
use App\Zen\System\Model\FxRateSource;
use Illuminate\Console\Command;

class UpdateSourceDataBond extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'databond:source';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates available data source in databond';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent ::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this -> info('Started updating');
        $response = DataBondService ::dataBondLogin();
        $bearerToken = json_decode($response) -> data;
        $value = (new DataBondService) -> setBearerToken($bearerToken) -> getDataBondRateSources();
        foreach(json_decode($value -> getContents(), true) as $item) {
            if(!is_array($item))
                continue;

            foreach($item as $source) {
                $dataBondSource = FxRateSource ::firstOrCreate(['source' => $source['Description'], 'source_id' => $source['Id']]);
            }
        }
        $this -> info('Finished updating');
        (new DataBondService) -> setBearerToken($bearerToken) -> getDataBondRateSources();
    }
}
