<?php


namespace App\Zen\User\Observer;


use App\Zen\User\Model\User;
use Illuminate\Support\Facades\Log;
use Laravel\Spark\Notification;

class UserObserver
{

    /**
     * Listen to the User created event.
     * @param User $user
     * @return void
     */
    public function created(User $user)
    {
        Log ::critical('New user created. User email: ' . $user -> email);

        $attr = [
            'user_id' => $user -> id,
            'action_text' => 'Welcome !',
            'body' => 'Welcome on board !. If you have any questions, please do not hesitate to contact me at support@leaseaccounting.app, and keep in mind that frequently asked questions can be found in “help” behind “?” icon.',
            ];
        Notification ::create($attr);
    }

    /**
     * Listen to the User created event.
     * @param User $user
     * @return void
     */
    public function updated(User $user)
    {

    }

}