@extends('layouts.master')
@section('content')
{!!Form::model($account,['id'=>'account-update-form','method'=>'PATCH', 'route'=>['accounts.update', $account->id],'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}

@include('Setting/accounts/partials/_form',['addOrEditText'=>'Edit'])
{!!Form::close()!!}

@stop
@section('javascript')
<script src="{{ mix('/js/zentreasury-form.js') }}"></script>
<script src="/js/vendor/jquery-ui.min.js"></script>
<script src="{{ mix('/js/custom/deals.js') }}"></script>
@stop