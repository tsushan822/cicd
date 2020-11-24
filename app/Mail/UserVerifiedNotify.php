<?php

namespace App\Mail;

use App\Zen\User\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerifiedNotify extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    private $url;
    /**
     * @var
     */
    private $roleUsers;

    private $user;

    /**
     * Create a new message instance.
     * @param $url
     * @param $roleUsers
     * @param user $user
     * @internal param $to
     */
    public function __construct($url, $roleUsers, User $user)
    {

        $this -> url = $url;
        $this -> roleUsers = $roleUsers;
        $this -> user = $user;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this -> subject('New Invitation!')
            -> with([
                'url' => $this -> url,
                'userRoles' => $this -> roleUsers,
                'user' => $this -> user
            ])
            -> markdown('emails.users.verification_notify');
    }
}
