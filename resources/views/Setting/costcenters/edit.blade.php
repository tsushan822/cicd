@extends('layouts.master')
@section('css')
    <style>

        .input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {

            margin-left: 5px !important;
            border-radius: 5px !important;
        }
    </style>
@stop
@section('content')
    {!!Form::model($costCenter,['id'=>'costcenter-update-form','method'=>'PATCH', 'route'=>['costcenters.update', $costCenter->id],'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}

    @include('Setting/costcenters/partials/_form',['addOrEditText'=>'Edit'])

    {!!Form::close()!!}

@stop

@section('javascript')
    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="/js/vendor/jquery-ui.min.js"></script>
    <script src="{{ mix('/js/custom/deals.js') }}"></script>
    <script type="text/javascript">

        $(function () {
            $('[data-toggle="popover"]').popover();
            $('#example').popover(options);
            $('#element').popover('toggle');
        });

    </script>
@stop