@extends('layouts.master')
@section('content')

            {!! Form::open(['url' => '/countries', 'class' => 'form-horizontal', 'files' => true]) !!}

            @include ('Setting.countries.form')

            {!! Form::close() !!}



@endsection
