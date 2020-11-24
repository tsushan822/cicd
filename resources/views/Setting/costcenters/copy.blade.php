@extends('layouts.master')
@section('css')
    <!-- Datatables -->
    <link href="/app/css/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/app/css/vendor/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="/app/css/vendor/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">


@stop
@section('content')
    {!!Form::model($costCenter,['id'=>'costcenter-update-form' ,'method'=>'POST', 'route'=>['costcenters.store'],
    'data-parsley-validate class'=>'form-horizontal form-label-left', 'files' => true])!!}
    @include('Setting/costcenters/partials/_form',['addOrEditText'=>'Add new'])
    {!!Form::close()!!}

@stop
@section('javascript')
    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="/js/vendor/jquery-ui.min.js"></script>
    <script src="{{ mix('/js/custom/deals.js') }}"></script>
@stop