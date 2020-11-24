<?php


namespace App\Listeners\System;

use App\Zen\System\Model\EmailLog;
use Hyn\Tenancy\Environment;
use Illuminate\Mail\Events\MessageSent;

class MessageSentListener
{

    /**
     * Create the event listener.
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * @param MessageSent $event
     */
    public function handle(MessageSent $event)
    {
        $env = app(Environment::class);
        $attr = [
            'website_id' => optional($env -> tenant()) -> id,
            'message' => null,
            'header' => $event -> message -> getHeaders(),
            'subject' => $event -> message -> getSubject(),
            'sending_at' => now(),
            'user_id' => auth() -> check() ? auth() -> id() : null,
        ];
        EmailLog ::create($attr);
    }
}

