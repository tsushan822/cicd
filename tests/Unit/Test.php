<?php

namespace Tests\Unit\Commands;

use App\Mail\TrialExpiringSoon;
use App\Zen\System\Model\Team;
use App\Zen\User\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Laravel\Spark\TeamSubscription;
use Tests\TestCase;

class EmailTeamsWithExpiringTrialsTest extends TestCase
{
    /** @var \App\CustomerTeam */
    protected $team;

    /** @var \App\User */
    protected $user;

    public function setUp()
    {
        parent ::setUp();

        $this -> user = factory(User::class) -> create();

        $this -> team = factory(Team::class) -> create([
            'trial_ends_at' => Carbon ::create(2018, 1, 31),
            'owner_id' => function () {
                return $this -> user -> id;
            }]);

        $this -> team -> users() -> attach($this -> user, ['role' => 'admin']);

        Mail ::fake();
    }

    /** @test */
    public function it_can_send_a_mail_concerning_a_trial_expiring_soon()
    {
        $this -> setNow(2018, 1, 29);
        $this -> artisan('teams:expiring-email');
        Mail ::assertNotSent(TrialExpiringSoon::class);

        $this -> setNow(2018, 1,
        $this -> artisan('teams:expiring-email');
        Mail ::assertSent(TrialExpiringSoon::class, 1);
        Mail ::assertSent(TrialExpiringSoon::class, function (TrialExpiringSoon $mail) {
            return $mail -> hasTo($this -> user -> email);
        });
    }

    /** @test */
    public function it_will_send_the_mail_concerning_a_trial_expiring_soon_only_once()
    {
        $this -> setNow(2018, 1, 30);

        $this -> artisan('teams:expiring-email');
        Mail ::assertSent(TrialExpiringSoon::class, 1);

        $this -> artisan('teams:expiring-email');
        Mail ::assertSent(TrialExpiringSoon::class, 1);
    }

    /** @test */
    public function it_will_not_send_the_mail_concerning_a_trial_expiring_soon_only_if_the_team_has_a_subscription()
    {
        $this -> setNow(2018, 1, 30);

        TeamSubscription ::create([
            'name' => 'default',
            'team_id' => $this -> team -> id,
            'stripe_id' => 'my-plan-id',
            'stripe_plan' => 'my-plan',
            'quantity' => 1,
        ]);

        $this -> artisan('teams:expiring-email');

        Mail ::assertNotSent(TrialExpiringSoon::class);
    }

    protected function setNow(int $year, int $month, int $day)
    {
        $newNow = Carbon ::create($year, $month, $day) -> startOfDay();

        Carbon ::setTestNow($newNow);

        return $this;
    }
}
