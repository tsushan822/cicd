@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
@stop
@section('content')
    {!!Form::open(['route'=>'post.lease.asset-lease-type','data-parsley-validate class'=>'form-horizontal form-label-left','id'=>'vueForm']) !!}
    @include('sub-views.reportForm',['model' => 'lease','StartEndOrReportDate'=>'StartWithMonth','title'=> Lang::get('master.RoU Asset by Lease Type'),'currency_is_required'=>'1'])
    {!!Form::close()!!}
    @include('reports.lease.table.rou-asset-table')
@stop

@push('form-js')

    <script>
        var allTranslation = "{!! __('master.All') !!}";

        $(document).ready(function () {
            var end_date = $("#end_date").val();
            var table = $.when($('#datatable-rou-asset').dataTable({
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "iDisplayLength": 25,
                dom: 'Bfrtip',
                "order": [],
                buttons: [
                    {
                        extend: "copy",
                        title: 'Lease RoU Asset by LeaseType ' + end_date,
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        title: 'Lease RoU Asset by LeaseType ' + end_date,
                        className: "btn-sm",
                        footer: true
                    },
                    {
                        extend: "excel",
                        title: 'Lease RoU Asset by LeaseType ' + end_date,
                        className: "btn-sm",
                        footer: true
                    },
                    {
                        extend: "pdfHtml5",
                        orientation: 'landscape',
                        title: 'Lease RoU Asset by LeaseType ' + end_date,
                        className: "btn-sm",
                        footer: true
                    },
                    {
                        extend: "print",
                        title: 'Lease RoU Asset by LeaseType ' + end_date,
                        className: "btn-sm"
                    },
                    {
                        extend: "pageLength",
                        className: "btn-sm"
                    }
                ]
            })).then(function(){
                $('.dt-button').addClass( "btn  waves-effect btn-sm").removeClass( "dt-button buttons-html5" );
                $('input[type=search]').addClass('form-control border-0 bg-light');
            });

        });
    </script>

    <script>

        // For Multiselect
        $(document).ready(function() {
            $('.js-multiselect').select2({
                placeholder: "{{Lang::get('master.Select (Optional)')}}",
                closeOnSelect: false
            });
        });
        // For CCY
        $(document).ready(function() {
            $('.js-singleselect').select2({
                placeholder: "{{Lang::get('master.Select (Optional)')}}"
            });
        });
    </script>
@endpush