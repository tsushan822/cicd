<?php
namespace App\Zen\Client\Service;

use App\Jobs\User\AddUserJob;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\System\Model\BackUp;
use App\Zen\System\Model\Customer;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class CreateCustomer
{

    private $name;
    private $fqdn;
    private $fxRateSource;

    public function __construct($customerData)
    {
        $this -> name = $customerData['name'];
        $this -> fqdn = $customerData['fqdn'];
        $this -> fxRateSource = $customerData['fx_rate_source'];
    }

    public function createCustomer()
    {
        $website = $this -> createWebsite();

        $this -> createHostName($website);

        $customer = $this -> createCustomerInput($website);

        $this -> createBackUp($customer);

        //$this -> createSuperAdmin($website);

        $this -> createParentCompany($customer);

        return $customer;
    }

    /**
     * @return Website
     */
    private function createWebsite(): Website
    {
        $website = new Website;
        // Implement custom random hash using Laravel Str::random
        $website -> uuid = Str ::random(10);
        app(WebsiteRepository::class) -> create($website);
        return $website;
    }

    /**
     * @param $name
     * @param Website $website
     */
    private function createHostName(Website $website): void
    {
        $hostname = new Hostname;
        $hostname -> main_sub_domain = explode('.', $this -> fqdn)[0];
        $hostname -> fqdn = $this -> fqdn;
        $hostname = app(HostnameRepository::class) -> create($hostname);
        app(HostnameRepository::class) -> attach($hostname, $website);
    }

    /**
     * @param Website $website
     * @param $customerName
     * @param $fxRateSource
     * @return Customer
     */
    private function createCustomerInput(Website $website): Customer
    {
        $attr = [
            'website_id' => $website -> id,
            'name' => $this -> name,
            'database' => $website -> uuid,
            'fx_rate_source' => $this -> fxRateSource,
            'terms_of_service' => file_get_contents(base_path('terms.md')),
            'ip_address' => Request ::ip()
        ];
        $customer = Customer ::create($attr);
        return $customer;
    }

    /**
     * @param Customer $customer
     */
    private function createBackUp(Customer $customer): void
    {
        $backUp = new BackUp;
        $backUp -> customer_id = $customer -> id;
        $backUp -> always_backup = 0;
        $backUp -> monthly_backup = 0;
        $backUp -> backup_days = 0;
        $backUp -> save();
    }

    /**
     * @param Website $website
     */
    private function createSuperAdmin(Website $website): void
    {
        $userDetails = config('user.super-admin');
        $userDetails['password'] = bcrypt($userDetails['password']);
        $userDetails['role'] = 'super';
        dispatch(new AddUserJob($website -> id, $userDetails)) -> onConnection('sync');
    }

    /**
     * @param mixed $name
     * @return CreateCustomer
     */
    public function setName($name)
    {
        $this -> name = $name;
        return $this;
    }

    /**
     * @param mixed $fqdn
     * @return CreateCustomer
     */
    public function setFqdn($fqdn)
    {
        $this -> fqdn = $fqdn;
        return $this;
    }

    /**
     * @param mixed $fxRateSource
     * @return CreateCustomer
     */
    public function setFxRateSource($fxRateSource)
    {
        $this -> fxRateSource = $fxRateSource;
        return $this;
    }

    private function createParentCompany(Customer $customer)
    {
        $attrParentCompany = [
            'short_name' => $customer -> name,
            'long_name' => $customer -> name,
            'is_parent_company' => 1,
            'is_entity' => 1,
            'is_counterparty' => 1,
            'is_external' => 0,
            'currency_id' => 2,
        ];
        Counterparty ::create($attrParentCompany);

    }
}