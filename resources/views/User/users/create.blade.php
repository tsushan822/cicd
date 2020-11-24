@extends('layouts.master')

@section('content')
{!!Form::open(['url'=>'/settings/users/create','data-parsley-validate class'=>'form-horizontal form-label-left']) !!}
@include('User/users/partials/_form',['addOrEditText'=>'Add new'])
{!!Form::close()!!}

@stop
