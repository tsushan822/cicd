@component('mail::message')
# Hello,

@if($deals['leases'])
<div>
<h2>These are the ending leases.</h2>
@foreach($deals['leases'] as $deal)
@component('mail::button', ['url' => $url.'/leases/'.$deal->id.'/edit'])
    Lease {{$deal->id}}. @if($deal->customer_reference)Customer Reference:- {{$deal->customer_reference}}.@endif
    Ending     on:- {{$deal->contractual_end_date}}
@endcomponent
@endforeach
<h3>You can unsubscribe from maturing leases with clicking button below.</h3>
@component('mail::button', ['url' => $url.'/users/'.$user->id.'/edit#email', 'color' => 'info'])
                Unsubscribe
@endcomponent
</div>
@endif

<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
