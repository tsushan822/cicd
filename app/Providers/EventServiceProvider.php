<?php

namespace App\Providers;

use App\Events\Lease\ClearAll;
use App\Events\Lease\LeaseChangeDelete;
use App\Events\System\DeleteFile;
use App\Events\System\DownloadFile;
use App\Events\System\ExecuteCommandEvent;
use App\Events\System\UploadFile;
use App\Listeners\AuditTrailForDeleteFile;
use App\Listeners\AuditTrailForUploadFile;
use App\Listeners\Lease\ClearAllListener;
use App\Listeners\Lease\LeaseChangeDeleteListener;
use App\Listeners\System\AuditTrailForDownloadFile;
use App\Listeners\System\CustomUpdateTrialEndDate;
use App\Listeners\System\ExecuteCommandListener;
use App\Listeners\System\TeamSubscribedListener;
use App\Listeners\System\UpdateTeamSubscription;
use App\Listeners\User\LockoutEventListener;
use App\Listeners\User\LogSuccessfulLogin;
use App\Listeners\User\LogSuccessfulLogout;
use App\Listeners\User\RecordFailedLoginAttempt;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Spark\Events\Teams\TeamCreated as CreatedTeam;
use Laravel\Spark\Listeners\Teams\Creation\TeamCreation;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * @var array
     */
    protected $listen = [
        Login::class => [LogSuccessfulLogin::class],

        Logout::class => [LogSuccessfulLogout::class],

        'App\Events\Event' => ['App\Listeners\EventListener'],

        UploadFile::class => [AuditTrailForUploadFile::class],

        DownloadFile::class => [AuditTrailForDownloadFile::class],

        DeleteFile::class => [AuditTrailForDeleteFile::class],

        LeaseChangeDelete::class => [LeaseChangeDeleteListener::class],

        ClearAll::class => [ClearAllListener::class],

        Failed::class => [RecordFailedLoginAttempt::class],

        Lockout::class => [LockoutEventListener::class],

        // User Related Events...
        'Laravel\Spark\Events\Subscription\UserSubscribed' => [
            'Laravel\Spark\Listeners\Subscription\UpdateActiveSubscription',
            'Laravel\Spark\Listeners\Subscription\UpdateTrialEndingDate',
        ],

        'Laravel\Spark\Events\Profile\ContactInformationUpdated' => [
            'Laravel\Spark\Listeners\Profile\UpdateContactInformationOnStripe',
        ],

        'Laravel\Spark\Events\PaymentMethod\VatIdUpdated' => [
            'Laravel\Spark\Listeners\Subscription\UpdateTaxPercentageOnStripe',
        ],

        'Laravel\Spark\Events\PaymentMethod\BillingAddressUpdated' => [
            'Laravel\Spark\Listeners\Subscription\UpdateTaxPercentageOnStripe',
        ],

        'Laravel\Spark\Events\Subscription\SubscriptionUpdated' => [
            'Laravel\Spark\Listeners\Subscription\UpdateActiveSubscription',
        ],

        'Laravel\Spark\Events\Subscription\SubscriptionCancelled' => [
            'Laravel\Spark\Listeners\Subscription\UpdateActiveSubscription',
        ],

        // Team Related Events...
        'Laravel\Spark\Events\Teams\Subscription\TeamSubscribed' => [
            UpdateTeamSubscription::class,
            TeamSubscribedListener::class,
            CustomUpdateTrialEndDate::class,
        ],

        'Laravel\Spark\Events\Teams\Subscription\SubscriptionUpdated' => [
            UpdateTeamSubscription::class
        ],

        'Laravel\Spark\Events\Teams\Subscription\SubscriptionCancelled' => [
            UpdateTeamSubscription::class
        ],

        'Laravel\Spark\Events\Teams\UserInvitedToTeam' => [
            'Laravel\Spark\Listeners\Teams\CreateInvitationNotification',
        ],

        CreatedTeam::class => [
            TeamCreation::class,
        ],

        ExecuteCommandEvent::class => [ExecuteCommandListener::class]
    ];

    /**
     * Register any other events for your application.
     * @return void
     */
    public function boot()
    {
        parent ::boot();

        //
    }
}
