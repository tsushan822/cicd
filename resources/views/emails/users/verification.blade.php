{{--@component('mail::message')
# Hi admin,
# User Verification

Please verify this user.

Name: {!! $name !!}<br>
Email: {!! $email !!}

@component('mail::button', ['url' => $url])
Verify User
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent--}}
@component('mail::layout')
@slot('header')
@component('mail::header', ['url' => config('app.url')])
LeaseAccounting.app
@endcomponent
@endslot
# Hi admin,
Please verify this user.

Name: {!! $name !!}<br>
Email: {!! $email !!}

@component('mail::button', ['url' => $url])
Verify User
@endcomponent

<p>If the link doesn't open, please click this link : {{$url}}</p>

Thanks,<br>
{{ config('app.name') }}


{{-- Subcopy --}}
@slot('subcopy')
@component('mail::subcopy')
@endcomponent
@endslot


{{-- Footer --}}
@slot('footer')
@component('mail::footer')
    LeaseAccounting.app<br>
    Helsinki, Finland
@endcomponent
@endslot
@endcomponent

