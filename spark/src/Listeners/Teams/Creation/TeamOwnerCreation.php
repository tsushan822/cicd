<?php


namespace Laravel\Spark\Listeners\Teams\Creation;


use App\Jobs\User\AddUserJob;
use App\Zen\System\Service\TeamService;

class TeamOwnerCreation
{
    /**
     * Handle the event.
     * @param mixed $event
     * @return void
     */
    public function handle($event)
    {
       /* $userDetails = [
            'name' => $event -> owner -> name,
            'password' => $event -> owner -> password,
            'email' => $event -> owner -> email,
            'verified' => '1',
            'must_change_password' => '0',
            'locale' => 'en',
            'role' => 'admin',
        ];
        $websiteId = TeamService ::websiteFromEmail($event -> member -> email);
        dispatch(new AddUserJob($websiteId, $userDetails));*/
    }
}