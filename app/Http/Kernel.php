<?php

namespace App\Http;

use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\ModuleNumber;
use App\Http\Middleware\SetupComplete;
use App\Http\Middleware\AuthToken;
use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\ModuleAvailability;
use App\Http\Middleware\RemoveComma;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Laravel\Spark\Http\Middleware\VerifyUserHasTeam;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     * These middleware are run during every request to your application.
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        TrustProxies::class,
        RemoveComma::class,
    ];

    /**
     * The application's route middleware groups.
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Laravel\Spark\Http\Middleware\CreateFreshApiToken::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     * These middleware may be assigned to groups or used individually.
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'dev' => \Laravel\Spark\Http\Middleware\VerifyUserIsDeveloper::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'hasTeam' => VerifyUserHasTeam::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'subscribed' => \Laravel\Spark\Http\Middleware\VerifyUserIsSubscribed::class,
        'teamSubscribed' => \Laravel\Spark\Http\Middleware\VerifyTeamIsSubscribed::class,
        'module' => ModuleAvailability::class,
        'moduleNumber' => ModuleNumber::class,
        'SetupComplete' => SetupComplete::class,
        'comma' => RemoveComma::class,
        'token' => AuthToken::class,
        'checkAdmin' => CheckAdmin::class,
    ];

    /**
     * The priority-sorted list of middleware.
     * This forces non-global middleware to always be in the given order.
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
