@extends('layouts.master')
@section('content')
    {!!Form::model($leaseType,['id'=>'lease-update-form' ,'method'=>'POST', 'route'=>['lease-types.store'],
    'data-parsley-validate class'=>'form-horizontal form-label-left', 'files' => true])!!}
    @include('Lease/lease-type/_form',['addOrEditText'=>'Add New','disabled' => false,'copy' => true])
    {!!Form::close()!!}

@stop