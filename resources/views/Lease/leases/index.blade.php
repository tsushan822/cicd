@extends('layouts.master')
@section('css')
@stop
@section('content')
    <!-- Table with panel -->
    @if($lease)
    <div class="alert alert-demo-lease alert-warning" role="alert">
        You have demo leases. <a href="/delete/demo">Delete</a>
    </div>
    @endif
        <div class="card  ">

            <div class="card-header crud_table_header mb-2 d-flex justify-content-between ">
                <div  class="d-flex align-items-center">
                    <span class="  pl-1">
                        <strong>  @if(request()->segment(2) == 'archive') @lang('master.Archived') @endif
                            @lang('master.Leases')</strong>
                        &nbsp;
                    </span>
                    <div class="total_lease">{{$numberOfLeases}}</div>
                </div>
                <div id="datatable-buttons">
                    @if(request()->segment(2) == 'archive')
                    @can('create_lease')
                        <a class="btn btn-sm  btn-primary-variant-one  px-2" href="{!! route('leases.index') !!}">
                            <i class="fas fa-archive"></i> <span>@lang('master.Non-archived')</span>
                        </a>
                    @endcan
                    @else
                        @can('create_lease')
                            <a class="btn btn-sm  btn-primary-variant-one  px-2" href="{!! route('leases.archive') !!}">
                                <i class="fas fa-archive"></i> <span>@lang('master.Archive')</span>
                            </a>
                        @endcan
                    @endif

                    @can('import_lease')
                        <a class="btn btn-sm  btn-primary-variant-one  px-2" href="{!! url('/import/Lease/lease') !!}">
                            <i class="fas fa-cloud-upload-alt"></i> <span>@lang('master.Import')</span>
                        </a>
                    @endcan
                        @can('create_lease')
                            <a class="btn btn-sm  btn-primary-variant-main  px-2" href="{!! route('leases.create') !!}">
                                <i class="fa fa-plus"></i> <span>@lang('master.Add new')</span>
                            </a>
                        @endcan
                </div>

            </div>

            <div class="px-4">
               {{-- <div  class="text-black text-underline title text-left mb-3 mx-3"><u><h3>@if(request()->segment(2) == 'archive') @lang('master.Archived') @endif
                            @lang('master.Lease Register')</h3></u></div>--}}

                <div class="table-wrapper" id="lease_area">
                    {!! $dataTable->table(['class' => 'table table-hover mb-0  dt-responsive  no-footer dtr-inline
              collapsed', 'id' => 'datatable-leases']) !!}
                </div>

            </div>

        </div>

    <!-- Table with panel -->

@stop

@section('javascript')



    {!! $dataTable->scripts() !!}
    <script>

        // Select the node that will be observed for mutations
        const targetNode = document.getElementById('lease_area');

        // Options for the observer (which mutations to observe)
        const config = { attributes: true, childList: true, subtree: false };

        // Callback function to execute when mutations are observed
        const callback = function(mutationsList, observer) {
            // Use traditional 'for loops' for IE 11
            mutationsList.forEach(function(e){
                try {
                    if(e.type==='childList'){
                        if(e.addedNodes[0].childNodes.length ){
                                   $('.dt-button').addClass( "btn btn-sm  btn-primary-variant-one  px-2").removeClass( "dt-button buttons-html5" );
                                   $('input[type=search]').addClass('form-control border-0 bg-light');
                                   $(".dt-buttons").appendTo("#datatable-buttons");
                                   $(".datatable-leases_filter").appendTo("#datatable-buttons");
                        }

                    }
                }
                catch(e){

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
