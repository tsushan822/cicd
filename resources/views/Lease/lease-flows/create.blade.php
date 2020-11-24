@extends('layouts.master')
@section('content')
    {!!Form::open(['route'=>'lease-flows.store','data-parsley-validate class'=>'form-horizontal form-label-left']) !!}
    @include('Lease/lease-flows/partials/_form')
    {!!Form::close()!!}
@stop

@section('javascript')
    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="/js/vendor/jquery-ui.min.js"></script>
    <script src="{{ mix('/js/custom/deals.js') }}"></script>
@stop