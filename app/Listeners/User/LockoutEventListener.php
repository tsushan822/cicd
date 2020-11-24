<?php

namespace App\Listeners\User;

use App\Mail\UserLocked;
use App\Zen\User\Model\User;
use App\Zen\User\UserList\AllUser;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Mail;

class LockoutEventListener
{
    use AllUser;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Lockout $event
     * @return void
     */
    public function handle(Lockout $event)
    {
        if(config('password_validation.enable_failed_login_lock')) {
            $toSystem = true;
            if($event -> request -> has('email')) {
                $user = User ::where('email', $event -> request -> input('email')) -> first();
                $user -> active_status = 0;
                $user -> wrong_password_blocked_at = now();
                $user -> save();
                if($user instanceof User) {
                    $admin = $this -> getUserFirst('admin');
                    if(!is_null($admin)) {
                        $toSystem = false;
                        Mail ::to($admin -> email) -> send(new UserLocked($user));
                    }
                }
            }

            if($toSystem) {
                $this -> sendToSystem();
            }
        }


    }

    public function sendToSystem()
    {
        Mail ::to(config('zensystem.email')) -> send(new UserLocked());
    }
}
