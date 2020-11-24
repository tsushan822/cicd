<?php

namespace App\Console\Commands\Tenancy;


use App\Mail\TrialExpiringSoon;
use App\Zen\System\Model\Team;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EmailTeamsWithExpiringTrials extends Command
{
    protected $signature = 'teams:expiring-email';

    protected $description = 'Email teams with expiring trials.';

    protected $mailsSent = 0;

    protected $mailFailures = 0;

    public function handle()
    {
        $this->info('Sending trial expiring soon mails...');

        Team::all()
            ->filter->onSoonExpiringTrial()
            ->each(function (Team $team) {
                $this->sendTrialEndingSoonMail($team);
            });

        $this->info("{$this->mailsSent} trial expiring mails sent!");

        if ($this->mailFailures > 0) {
            $this->error("Failed to send {$this->mailFailures} trial expiring mails!");
        }
    }

    protected function sendTrialEndingSoonMail(Team $team)
    {
        try {
            if ($team->wasAlreadySentTrialExpiringSoonMail()) {
                return;
            }

            $this->comment("Mailing {$team->owner->email} (team {$team->name})");
            Mail::to($team->owner->email)->send(new TrialExpiringSoon($team));

            $this->mailsSent++;

            $team->rememberHasBeenSentTrialExpiringSoonMail();
        } catch (Exception $exception) {
            $this->error("exception when sending mail to team {$team->id}", $exception);
            report($exception);
            $this->mailFailures++;
        }
    }
}
