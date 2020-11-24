<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 19/10/2017
 * Time: 16.48
 */

namespace App\Zen\User\Model;

use App\Mail\UserVerifiedNotify;
use App\Repository\Eloquent\Repository;
use App\Zen\Setting\Model\AdminSetting;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\MaturingNotification;
use App\Zen\System\Model\Customer;
use App\Zen\System\Model\Team;
use App\Zen\System\Service\TeamService;
use App\Zen\User\Service\UserService;
use Hyn\Tenancy\Facades\TenancyFacade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Spark\Spark;


class UserRepository extends Repository
{
    public function model()
    {
        return User::class;
    }

    public function verifyUserAndRole($request)
    {
        $userId = $request -> user_id;
        $roles = $request -> role;
        $user = $this -> find($userId);
        foreach($roles as $role) {
            $role = Role ::find($role);
            $user -> roles() -> save($role);
        }
        $this -> update(['verified' => 1], $userId);
        //Sending Mail to user that they have been verified
        $userRoles = $user -> roles;
        $url = url('main');
        Mail ::to($user -> email) -> send(new UserVerifiedNotify($url, $userRoles, $user));
    }

    public function handleCreate($request)
    {

        //create random password according to the password rules
        $randomPassword = Str ::random($this -> minPasswordLength());

        //bcrypt password and create an user
        $password = bcrypt($randomPassword);
        $request -> request -> add(['password' => $password]);


        $user = $this -> create($request -> all());
        $team = Team ::first();
        $user -> current_team_id = $team -> id;
        $user -> verified = 1;
        $team -> users() -> attach($user, ['role' => Spark ::defaultRole()]);
        $user -> save();

        UserService ::registerAuthy($user);
        //assign companies
        if(isset($request -> counterparty)) {
            foreach($request -> counterparty as $counterparty) {
                $counterparty = Counterparty ::find($counterparty);
                $user -> counterparties() -> save($counterparty);
            }
        }
        //verify and assign roles
        foreach($request -> role as $role) {
            $role = Role ::find($role);
            $user -> roles() -> save($role);
        }

        TeamService ::addUserInSystem($user -> email, $team -> customer_id);

        return $user;
    }

    public function updateUserDetails($request, $userId)
    {

        $requestedRoles = $request -> role;
        $user = $this -> find($userId);
        if(!Gate ::denies('edit_user')) {

            foreach($user -> roles as $role) {
                if($role -> name == 'super') {
                    $requestedRoles[] = $role -> id;
                }
            }
            $user -> counterparties() -> detach();
            if(isset($request -> role)) {
                $user -> roles() -> detach();
                foreach($requestedRoles as $role) {
                    $role = Role ::find($role);
                    $user -> roles() -> save($role);
                }
            }
            if(isset($request -> counterparty)) {
                foreach($request -> counterparty as $counterparty) {
                    $counterparty = Counterparty ::find($counterparty);
                    $user -> counterparties() -> save($counterparty);
                }
            }
            $user -> name = $request -> name;

        }

        $user -> two_factor_type = $request -> two_factor_type;
        $user -> dialing_code = $request -> dialing_code;
        $user -> phone_number = $request -> phone_number;

        $user -> locale = $request -> locale;
        $user -> active_status = $request -> active_status;
        $user -> save();

        UserService ::registerAuthy($user);

        MaturingNotification ::updateOrCreate(['user_id' => $userId, 'type' => 'lease_maturing_notify'],
            ['prior_days' => $request -> lease_maturing_notify_prior_days, 'active_status' => $request -> lease_maturing_notify]);

        flash(trans("master.User data updated"), trans("master.Success!")) -> overlay();
    }

    private function minPasswordLength()
    {
        $adminSetting = AdminSetting ::first();
        if($adminSetting instanceof AdminSetting) {
            if(!is_null($adminSetting -> min_password_length))
                config(['password_validation.min_length' => $adminSetting -> min_password_length]);

        }
        return config('password_validation.min_length');
    }
}