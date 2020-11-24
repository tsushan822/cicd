@extends('layouts.master')
@section('content')
    {!! Form::open(['url' => '/lease-types', 'class' => 'form-horizontal', 'files' => true]) !!}
    @include ('Lease.lease-type._form',['addOrEditText' => 'Add New'])
    {!! Form::close() !!}
@endsection
@section('javascript')

    <script>
        new Vue({
            el: '#prefill',
            created(){
            }
        });
    </script>
@endsection
