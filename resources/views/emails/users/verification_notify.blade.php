@component('mail::message')
# New Invitation

@component('mail::panel')
@if($user->two_factor_type == 'app')
    <br>You have two factor authentication enabled please follow the sms message and install the app to use this feature.
@endif
@endcomponent

You have now been invited to LeaseAccounting.app <br>Your assigned roles are:
@foreach($userRoles as $userRole)
    - {!! $userRole ->label !!}
@endforeach
Please set new password to use the application.
@component('mail::button', ['url' => $url])
Set Password
@endcomponent

Thanks,<br>
LeaseAccounting.app<br>
Helsinki, Finland
@endcomponent
