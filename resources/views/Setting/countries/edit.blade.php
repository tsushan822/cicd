@extends('layouts.master')
@section('css')

@stop
@section('content')
    {!!Form::model($country,['id'=>'deal-update-form', 'method'=>'PATCH', 'route'=>['countries.update', $country->id],
    'data-parsley-validate class'=>'form-horizontal form-label-left','files' => true])!!}

    @include('Setting/countries/form', ['addOrEditText'=>'Edit'])

    {!!Form::close()!!}

@stop
@section('javascript')
    <script src="{{ mix('/js/custom/fx_deals.js') }}"></script>
@stop