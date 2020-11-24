@extends('layouts.master')
@section('css')
@stop
@section('content')
    <!-- Table with panel -->
    <div class="card ">
        <div class="card-header crud_table_header mb-2 d-flex justify-content-between ">
            <div class="d-flex align-items-center">
                <h6 class="  pl-1">
                    <strong>  @lang('master.Foreign exchange rates')</strong>
                </h6>
            </div>
            <div id="datatable-buttons">
                @can('import_fxrate')
                    <a class="btn btn-sm  btn-primary-variant-one  px-2" href="{!! url('/import/FxDeal/fxrate') !!}">
                        <i class="fas fa-cloud-upload-alt mt-0"></i>
                        @lang('master.Import')
                    </a>
                @endcan
                @can('create_fxrate')
                    <a class="btn btn-sm  btn-primary-variant-main  px-2" href="{!! route('fxrates.create') !!}">
                        <i class="fas fa-plus mt-0"></i>
                        @lang('master.Add new')
                    </a>
                @endcan
            </div>

        </div>
        <div class="px-4">

            <div class="table-wrapper" id="costcenter_table_area">
                {!! $dataTable->table(['class' => 'table table-hover mb-0  dt-responsive  no-footer dtr-inline
           collapsed', 'id' => 'datatable-rates']) !!}
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
        const targetNode = document.getElementById('costcenter_table_area');

        // Options for the observer (which mutations to observe)
        const config = {attributes: true, childList: true, subtree: false};

        // Callback function to execute when mutations are observed
        const callback = function (mutationsList, observer) {
            // Use traditional 'for loops' for IE 11
            mutationsList.forEach(function (e) {
                try {
                    if (e.type === 'childList') {
                        if (e.addedNodes[0].childNodes.length) {
                            $('.dt-button').addClass("btn btn-sm  btn-primary-variant-one  px-2").removeClass("dt-button buttons-html5");
                            $('input[type=search]').addClass('form-control border-0 bg-light');
                            $(".dt-buttons").appendTo("#datatable-buttons");
                            $(".datatable-leases_filter").appendTo("#datatable-buttons");
                        }

                    }
                } catch (e) {

                }
            });

            /**/
        };

        // Create an observer instance linked to the callback function
        const observer = new MutationObserver(callback);

        // Start observing the target node for configured mutations
        observer.observe(targetNode, config);

    </script>
@stop


