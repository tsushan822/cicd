@extends('layouts.master')
@section('css')
    <!-- Datatables -->
    <link href="/app/css/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/app/css/vendor/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="/app/css/vendor/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">


@stop
@section('content')
    {!!Form::model($counterparty,['id'=>'counterparty-update-form' ,'method'=>'POST', 'route'=>['counterparties.store'],
    'data-parsley-validate class'=>'form-horizontal form-label-left', 'files' => true])!!}
    @include('Setting/counterparties/partials/_form',['addOrEditText'=>'Add New'])
    {!!Form::close()!!}

@stop
@section('javascript')
    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="/js/vendor/jquery-ui.min.js"></script>
    <script src="{{ mix('/js/custom/deals.js') }}"></script>
@stop