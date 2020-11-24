<?php


namespace App\Zen\System\Service;

use App\Facades\Cloudflare;
use App\Jobs\Leases\AddDemoLeasesJob;
use App\Mail\FollowEmail;
use App\Mail\WelcomeEmail;
use App\Zen\Client\Service\CreateCustomer;
use App\Zen\System\Model\Team;
use App\Zen\System\Model\Module;
use App\Zen\System\Model\Customer;
use App\Zen\User\Model\User;
use Carbon\Carbon;
use Hyn\Tenancy\Models\Hostname;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Laravel\Spark\Interactions\Settings\Teams\AddTeamMember;
use Laravel\Spark\Spark;
use Laravel\Spark\Token;

class RegisterService
{
    use FqdnService;

    private $customer;
    private $fqdn;
    private $team = null;

    public function registerNewCustomer($request)
    {
        $customer = $this -> creatingNewCustomerRecord($request);

        if(App ::environment(['production']))
            $this -> registerCloudFlare();

        $user = $this -> createFirstUser($request);

        $this -> createTeam($request, $user);


        $this -> addUserDomain($user);

        $this -> addModules();

        $token = $this -> createTokenAndPermission($user);

        $this -> addDemoLeases();

        $this -> sendWelcomeEmail($user);

        return array($token, $this -> fqdn, $user, $this -> customer);
    }

    /**
     * @param $request
     * @return Customer
     */
    private function creatingNewCustomerRecord($request)
    {
        $customerData['fx_rate_source'] = $request -> input('fx-rate-source');
        $customerData['name'] = $request -> input('team');
        $subDomain = $this -> checkFqdn($customerData['name']);
        $this -> fqdn = $subDomain . '.' . config('zenlease.server_url');
        $customerData['fqdn'] = $this -> fqdn;
        $customer = (new CreateCustomer($customerData)) -> createCustomer();
        return $customer;

    }

    /**
     * @param $user
     * @return string
     */
    private function createTokenAndPermission($user): string
    {
        $user -> assign('admin');

        $user -> counterparties() -> attach(2);

        $token = md5(now());
        $attrToken = [
            'id' => $token,
            'name' => 'First login',
            'user_id' => $user -> id,
            'customer_id' => $this -> customer -> id,
            'expires_at' => now() -> addMinutes(10),
            'token' => $token,
            'metadata' => 'null',
        ];
        $tokenObj = Token ::create($attrToken);
        return $token;
    }

    public function registerCloudFlare()
    {
        $returnValue = Cloudflare ::addRecord($this -> fqdn, config('cloudflare.content'));
        sleep(5);
        if($returnValue) {
            //Send cloudflare success mail to support
        } else {
            //Send cloudflare unsuccessful mail to support
        }
    }

    public function addUserDomain($user)
    {
        $domain = substr($user -> email, strpos($user -> email, '@') + 1);
        $this -> customer -> user_domains = $domain;
        $this -> customer -> save();
    }

    private function addModules()
    {
        //Check based on plan chosen
        if(1) {
            $leaseNumber = config('zenlease.initial_lease_number.basic');
            $userNumber = config('zenlease.initial_user_number.basic');
            $companyNumber = config('zenlease.initial_company_number.basic');
        } elseif(2) {
            $leaseNumber = config('zenlease.initial_lease_number.professional');
            $userNumber = config('zenlease.initial_user_number.professional');
            $companyNumber = config('zenlease.initial_company_number.professional');
        } else {
            $leaseNumber = config('zenlease.initial_lease_number.enterprise');
            $userNumber = config('zenlease.initial_user_number.enterprise');
            $companyNumber = config('zenlease.initial_company_number.enterprise');
        }
        Module ::create([
            'name' => 'Lease',
            'available_number' => $leaseNumber,
            'available' => 1,
            'customer_id' => $this -> customer -> id,
        ]);

        Module ::create([
            'name' => 'User',
            'available_number' => $userNumber,
            'available' => 1,
            'customer_id' => $this -> customer -> id,
        ]);

        Module ::create([
            'name' => 'Company',
            'available_number' => $companyNumber,
            'available' => 1,
            'customer_id' => $this -> customer -> id,
        ]);
    }

    private function createFirstUser($request)
    {
        $hostname = Hostname ::where('fqdn', $this -> fqdn) -> first();
        $this -> customer = Customer ::where('website_id', $hostname -> website_id) -> first();

        $attr = [
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => bcrypt($request -> password),
            'customer_id' => $this -> customer -> id,
            'is_owner' => 1,
        ];
        $user = User ::create($attr);

        TeamService ::addUserInSystem($attr['email'], $attr['customer_id']);

        return $user;
    }

    private function createTeam($request, $user)
    {
        $attributes = [
            'id' => $this -> customer -> database,
            'owner_id' => $user -> id,
            'name' => $request -> team,
            'customer_id' => $this -> customer -> id,
            'trial_ends_at' => Carbon ::now() -> addDays(config('cashier.trial_days')),
        ];

        $this -> team = Team ::create($attributes);
        $user -> current_team_id = $this -> team -> id;
        $user -> save();

        $this -> customer -> team_id = $this -> team -> id;
        $this -> customer -> trial_ends_at = Carbon ::now() -> addDays(config('cashier.trial_days'));
        $this -> customer -> save();

        (new AddTeamMember()) -> handle($this -> team, $user, 'owner');
    }


    private function addDemoLeases()
    {
        dispatch(new AddDemoLeasesJob($this -> customer -> website_id)) -> delay(now() -> addSeconds(1));
    }

    private function sendWelcomeEmail($user)
    {
        //Send email when subscribed
        $when = now() -> addMinutes(5);
        Mail ::to($user)
            //->bcc(config('super-admin.email'))
            -> later($when, new WelcomeEmail());

        //Send follow-up email after subscribe email
        $whenFollowUp = now() -> addHours(4);
        Mail ::to($user)
            //->bcc(config('super-admin.email'))
            -> later($whenFollowUp, new FollowEmail());

    }
}