@extends('layouts.master')
@section('content')
   {!!Form::open(['route'=>'counterparties.store','data-parsley-validate class'=>'form-horizontal form-label-left']) !!}

@include('Setting/counterparties/partials/_form',['addOrEditText'=>'Add New'])
{!!Form::close()!!}

@stop
@section('javascript')
<script src="{{ mix('/js/zentreasury-form.js') }}"></script>
<script src="/js/vendor/jquery-ui.min.js"></script>
<script src="{{ mix('/js/custom/deals.js') }}"></script>
@stop