<?php


namespace App\Zen\System\Service;


use App\Scopes\UserCompanyScope;
use App\Zen\System\Model\Customer;
use App\Zen\User\Model\User;
use Exception;
use Illuminate\Support\Facades\DB;

class TeamService
{
    public static function websiteFromEmail(string $email): int
    {

        $user = DB ::connection('system') -> table('users') -> where('active_status', 1) -> where('email', $email) -> first();

        if($user -> customer_id)
            $customer = Customer ::where('id', $user -> customer_id) -> first();
        else
            throw new Exception('User not found or not active');

        if($customer instanceof Customer)
            return $customer -> website_id;
        else
            throw new Exception('Error occurred');

    }

    public static function addUserInSystem($email, $websiteId)
    {
        DB ::connection('system') -> table('users') -> insert(
            ['email' => $email, 'customer_id' => $websiteId]
        );
    }
}