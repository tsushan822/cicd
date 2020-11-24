@component('mail::message')
# Hi

The ip with email {{ request()->ip() }} is trying failed login attempts in {{ url()->current() }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
