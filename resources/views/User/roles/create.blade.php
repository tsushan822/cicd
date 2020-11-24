@extends('layouts.master')
@section('content')
    {!!Form::open(['route'=>'roles.store','id'=>'mmdeal-update-form',
    'data-parsley-validate class'=>'form-horizontal form-label-left']) !!}
    @include('User/roles/partials/_form',['addOrEditText'=>'Add new'])
    {!!Form::close()!!}
@endsection