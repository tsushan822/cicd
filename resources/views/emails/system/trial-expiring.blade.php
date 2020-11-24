@component('mail::message')
# Hello

Your trial is expiring on {{ $team->trial_ends_at }}.

@component('mail::button', ['url' => ''])
Go to application
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
