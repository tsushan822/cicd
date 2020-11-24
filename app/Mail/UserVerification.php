<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserVerification extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $email;
    /**
     * @var
     */
    private $url;

    /**
     * Create a new message instance.
     * @return void
     */
    public function __construct($name, $email, $url)
    {
        $this -> name = $name;
        $this -> email = $email;
        $this -> url = $url;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this -> with([
            'name' => $this -> name,
            'email' => $this -> email,
            'url' => $this -> url,
        ])
            -> subject('User Verification Email')
            -> markdown('emails.users.verification');
    }
}
