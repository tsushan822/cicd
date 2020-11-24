@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
@stop
@section('content')

    {!!Form::open(['route'=>'post.lease.valuation','data-parsley-validate class'=>'form-horizontal form-label-left','id'=>'vueForm']) !!}
    @include('sub-views.reportForm',['model' => 'lease','StartEndOrReportDate'=>'ReportDate','title'=> Lang::get('master.Lease Valuation Report')])
    {!!Form::close()!!}
    @include('reports.lease.table.lease-valuation-table')
@stop

@push('form-js')

    <script>
        var allTranslation = "{!! __('master.All') !!}";

        $(document).ready(function () {
            var start_date = $("#start_date").val();
            var table = $.when($('#datatable-lease-valuation').dataTable({
                "aLengthMenu": [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]],
                "iDisplayLength": 100,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: "copy",
                        title: 'Lease Valuation ' + start_date,
                        className: "btn-sm btn-primary-variant-one",
                        footer: true
                    },
                    {
                        extend: "csv",
                        title: 'Lease Valuation ' + start_date,
                        className: "btn-sm btn-primary-variant-one",
                        footer: true
                    },
                    {
                        extend: "excel",
                        title: 'Lease Valuation ' + start_date,
                        className: "btn-sm btn-primary-variant-one",
                        footer: true
                    },
                    {
                        extend: "pdfHtml5",
                        orientation: 'landscape',
                        title: 'Lease Valuation ' + start_date,
                        className: "btn-sm btn-primary-variant-one",
                        pageSize: 'LEGAL',
                        footer: true
                    },
                    {
                        extend: "print",
                        title: 'Lease Valuation ' + start_date,
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