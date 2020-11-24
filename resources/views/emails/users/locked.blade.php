@component('mail::message')
# Hi

The user with email {{ $user -> email }} is locked due to multiple failed login attempts.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
