<?php

namespace Tests;

use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\User\Model\User;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use PHPUnit\Framework\Assert;

abstract class DuskTestCase extends BaseTestCase
{

    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static ::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions) -> addArguments([
            '--disable-gpu',
            '--headless',
            '--window-size=2400,2000',
            '--no-sandbox'

        ]);

        return RemoteWebDriver ::create(
            'http://localhost:9515', DesiredCapabilities ::chrome() -> setCapability(
            ChromeOptions::CAPABILITY, $options
        )
        );
    }

    /**
     * @param string $leaseAmount
     * @param string $leaseType
     * @param string $startDate
     * @param string $endDate
     * @param string $leaseRate
     * @param string $firstPaymentDate
     * @param int $paymentsPerYear
     * @param int $leaseServiceCost
     * @param array $extra
     * @return int
     * @throws \Throwable
     */
    final public function create_lease(string $leaseAmount, string $leaseType, string $startDate, string $endDate, string $leaseRate, string $firstPaymentDate, $paymentsPerYear = 12, $leaseServiceCost = 0, $extra = []): int
    {
        $user = User ::find(1);
        $this -> browse(function ($first) use ($user, $leaseAmount, $leaseType, $startDate, $endDate, $leaseRate, $firstPaymentDate, $paymentsPerYear, $leaseServiceCost) {
            $first -> loginAs($user) -> visit('/leases/create')
                -> select('#currency_id', '2')
                -> type('#lease_amount', $leaseAmount)
                -> type('#lease_service_cost', $leaseServiceCost)
                -> select('#entity_id', '2')
                -> select('#counterparty_id', '1')
                -> select('#lease_type_id', $leaseType)
                -> select('#portfolio_id', 1)
                -> select('#cost_center_id', 1)
                -> select('#lease_flow_per_year', $paymentsPerYear)
                -> type('#customer_reference', 'Some reference')
                -> type('#effective_date', $startDate)
                -> type('#maturity_date', $endDate)
                -> type('#first_payment_date', $firstPaymentDate)
                -> type('#lease_rate', $leaseRate)
                -> pause(500)
                -> press('#register_submit')
                -> assertSee('Payment schedule generator')
                -> press('#register_submit')
                -> press('#register_submit')
                -> assertSee('Lease agreement');
        });

        return Lease ::max('id');
    }

    /**
     * @param string $leaseAmount
     * @param string $extensionType
     * @param $lease
     * @return void
     * @throws \Throwable
     */
    final public function create_lease_extension(string $leaseAmount, int $lease, string $extensionType = 'Increase in scope / term'): void
    {
        $user = User ::find(1);
        $this -> browse(function ($first) use ($user, $lease, $leaseAmount, $extensionType) {
            $first -> loginAs($user) -> visit('/leases/' . $lease . '/edit')
                -> click('#leasechange')
                -> assertSee('Lease agreement');
        });
    }

    public function match_with_database($lease, $leaseExist)
    {
        $leaseFlows = LeaseFlow ::where('lease_id', $lease) -> get();
        $leaseFlowsExist = LeaseFlow ::where('lease_id', $leaseExist) -> get();
        $i = 0;
        foreach($leaseFlows as $leaseFlow) {
            Assert ::assertTrue($leaseFlow -> variations == $leaseFlowsExist[$i] -> variations);
            Assert ::assertTrue($leaseFlow -> repayment == $leaseFlowsExist[$i] -> repayment);
            Assert ::assertTrue($leaseFlow -> interest_cost == $leaseFlowsExist[$i++] -> interest_cost);
        }
    }

    public function delete_lease(int $firstCreated): void
    {
        $this -> browse(function ($first) use ($firstCreated) {
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');
        });
    }

    public function match_with_database_ext(int $lease, int $leaseExist)
    {
        $leaseExtExist = LeaseExtension ::where('lease_id', $leaseExist) -> orderBy('id', 'asc') -> first();
        $leaseFlowsExist = LeaseFlow ::where('lease_extension_id', $leaseExtExist -> id) -> withTrashed() -> get();
        $leaseFlows = LeaseFlow ::where('lease_id', $lease) -> get();
        $i = 0;
        foreach($leaseFlows as $leaseFlow) {
            Assert ::assertTrue($leaseFlow -> variations == $leaseFlowsExist[$i] -> variations);
            Assert ::assertTrue($leaseFlow -> repayment == $leaseFlowsExist[$i] -> repayment);
            Assert ::assertTrue($leaseFlow -> interest_cost == $leaseFlowsExist[$i++] -> interest_cost);
        }
    }
}
