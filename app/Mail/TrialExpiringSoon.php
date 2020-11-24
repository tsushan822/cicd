<?php

namespace App\Mail;


use App\Zen\System\Model\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrialExpiringSoon extends Mailable
{
    use Queueable, SerializesModels;

    public $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function build()
    {
        return $this
            ->subject("Trial account will expire soon")
            ->markdown('emails.system.trial-expiring', [
                'team' => $this->team,
            ]);
    }
}
