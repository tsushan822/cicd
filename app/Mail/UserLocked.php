<?php

namespace App\Mail;

use App\Zen\User\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLocked extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var null
     */
    protected $user;

    /**
     * Create a new message instance.
     *
     * @param null $user
     */
    public function __construct($user = null)
    {
        $this -> user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this -> user) {
            return $this -> markdown('emails.users.locked') -> with(['user' => $this -> user]);
        } else {
            return $this -> markdown('emails.users.wrong');
        }
    }
}
