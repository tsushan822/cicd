@extends('layouts.master')
@section('css')
@stop
@section('content')

    <!-- Table with panel -->
    <div class="card ">
        <div class="card-header crud_table_header mb-2 d-flex justify-content-between ">
            <div class="d-flex align-items-center">
                <h6 class="  pl-1">
                    <strong>  @lang('master.Lease types')</strong>
                </h6>
            </div>
            @can('create_lease_type')
                <div id="datatable-buttons">
                    <a class="btn btn-sm  btn-primary-variant-main  px-2" href="{!! route('lease-types.create') !!}">
                        <i class="fa fa-plus"></i> @lang('master.Add new')
                    </a>
                </div>
            @endcan

        </div>
        <div class="px-4">

            <div class="table-wrapper">
                {!! $dataTable->table(['class' => 'table table-hover mb-0  dt-responsive  no-footer dtr-inline
             collapsed', 'id' => 'datatable-lease-types']) !!}
            </div>

        </div>

    </div>

    <!-- Table with panel -->

@stop

@section('javascript')

    {!! $dataTable->scripts() !!}
    <style>
        .table.dataTable tbody th, table.dataTable tbody td {
            text-align: left !important;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('.dt-button').addClass("btn btn-sm  btn-primary-variant-one  px-2").removeClass("dt-button buttons-html5");
            $('input[type=search]').addClass('form-control border-0 bg-light');
            $(".dt-buttons").appendTo("#datatable-buttons");
            $(".datatable-leases_filter").appendTo("#datatable-buttons");
        });

    </script>
@stop


