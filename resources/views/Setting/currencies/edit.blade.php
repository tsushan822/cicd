@extends('layouts.master')
@section('content')
{!!Form::model($currency,['id'=>'ccy-update-form','method'=>'PATCH', 'route'=>['currencies.update', $currency->id]])!!}

@include('Setting/currencies/partials/_form')
{!!Form::close()!!}



@stop
