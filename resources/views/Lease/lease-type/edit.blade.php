@extends('layouts.master')
@section('content')
    {!! Form::model($leasetype, ['method' => 'PATCH','route' => ['lease-types.update', $leasetype->id],'class' => 'form-horizontal','files' => true ]) !!}
    @include ('Lease.lease-type._form',['addOrEditText' => 'Edit'])
    {!! Form::close() !!}
@endsection
