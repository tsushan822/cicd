@extends('layouts.master')
@section('content')

    {!!Form::model($leaseFlow,['id'=>'leaseflow-update-form','method'=>'PATCH', 'route'=>['lease-flows.update', $leaseFlow->id],'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}
    @include('Lease/lease-flows/partials/_form')
    {!!Form::close()!!}
@stop
@section('javascript')

    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="{{ mix('/js/custom/deals.js') }}"></script>

@stop