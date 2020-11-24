@extends('layouts.master')
@section('css')
@stop
@section('content')
    {!!Form::open(['route'=>'post.reporting.month-value','data-parsley-validate class'=>'form-horizontal form-label-left','id'=>'vueForm']) !!}
     @include('sub-views.reportForm',['model' => 'lease','StartEndOrReportDate'=>'ReportDate','title'=> Lang::get('master.Month End Value')])
  {!!Form::close()!!}
    @include('reports.lease.table.month-value-table')
@stop


@push('form-js')

    <script>
        var allTranslation = "{!! __('master.All') !!}";

        $(document).ready(function () {
            var start_date = $("#end_date").val();
            var table = $.when($('#datatable-month-payment').dataTable({
                "aLengthMenu": [[10, 25, 50, 200, 500, -1], [10, 25, 50, 200, 500, "All"]],
                "iDisplayLength": 25,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: "copy",
                        title: 'Lease Month End ' + start_date,
                        className: "btn-sm btn-primary-variant-one"
                    },
                    {
                        extend: "csv",
                        title: 'ZenTreasury Lease Month End ' + start_date,
                        className: "btn-sm btn-primary-variant-one",
                        footer: true
                    },
                    {
                        extend: "excel",
                        title: 'Lease Month End ' + start_date,
                        className: "btn-sm btn-primary-variant-one",
                        footer: true
                    },
                    {
                        extend: "pdfHtml5",
                        orientation: 'landscape',
                        title: 'Lease Month End ' + start_date,
                        className: "btn-sm btn-primary-variant-one",
                        pageSize: 'A3',
                        footer: true
                    },
                    {
                        extend: "print",
                        title: 'Lease Month End ' + start_date,
                        className: "btn-sm btn-primary-variant-one"
                    },
                    {
                        extend: "pageLength",
                        className: "btn-sm btn-primary-variant-one"
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

@push('header-scripts-area')
    <style>
        .sorting_1:before {
            top: 12px !important;
            background-color: #13b6ea !important;
            left: 2px !important;
        }
    </style>
@endpush