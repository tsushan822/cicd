@extends('layouts.master')
@section('content')
        {!!Form::model($user,['id'=>'user-update-form','method'=>'PATCH', 'route'=>['users.update', $user->id],
        'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}
        @include('User/users/partials/_form')
        {!!Form::close()!!}
@endsection
