@extends('layouts.master')
@section('css')
@stop
@section('content')
    <!-- Table with panel -->
    <div class="pb-4 pt-4">
        <div class="card card-cascade narrower mt-4">

            <!--Card image-->
            <div
                    class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
                <a href="" class="white-text mx-3"> @lang('master.Account')</a>
                <div>
                    @can('create_lease')
                        <a class="btn btn-outline-white  btn-sm px-2" href="{!! route('accounts.create') !!}">
                            <i class="fa fa-plus"></i> @lang('master.Add new')
                        </a>
                    @endcan
                    @can('import_data')
                        <a class="btn btn-outline-white  btn-sm px-2" href="{!! url('/import/BookKeeping/account') !!}">
                            <i class="fas fa-cloud-upload-alt"></i> @lang('master.Import')
                        </a>
                    @endcan
                </div>



            </div>
            <!--/Card image-->

            <div class="px-4" >

                <div class="table-wrapper" id="costcenter_table_area">
                    {!! $dataTable->table(['class' => 'table table-hover mb-0  dt-responsive  no-footer dtr-inline
              collapsed', 'id' => 'datatable-accounts']) !!}
                </div>

            </div>

        </div>
    </div>

    <!-- Table with panel -->

@stop

@section('javascript')
    {!! $dataTable->scripts() !!}
    <script src="{{asset('/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <style>
        .active-cyan input[type=text] {
            border-bottom: 1px solid #4dd0e1;
            box-shadow: 0 1px 0 0 #4dd0e1;
        }
    </style>
    <script>
        const targetNode = document.getElementById('costcenter_table_area');

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








