@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
@stop
@section('content')
    {!!Form::open(['route'=>'post.lease.additions-rou-asset','data-parsley-validate class'=>'form-horizontal form-label-left','id'=>'vueForm']) !!}
    @include('sub-views.reportForm',['model' => 'lease','StartEndOrReportDate'=>'ReportDate','title'=> Lang::get('master.Additions to Right of Use Asset')])
    {!!Form::close()!!}
    @include('reports.lease.table.additions-rou-asset-table')
@stop


@push('form-js')

    <script>
        var allTranslation = "{!! __('master.All') !!}";

        $(document).ready(function () {
            var end_date = $("#end_date").val();
            var table = $.when($('#datatable-additions-rou-asset').dataTable({
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "iDisplayLength": 25,
                dom: 'Bfrtip',
                "order": [[2, "asc"]],
                buttons: [
                    {
                        extend: "copy",
                        title: 'Additions Right of Use Asset ' + end_date,
                        className: "btn-sm btn-primary-variant-one"
                    },
                    {
                        extend: "csv",
                        title: 'Additions Right of Use Asset '  + end_date,
                        className: "btn-sm btn-primary-variant-one",
                        footer: true
                    },
                    {
                        extend: "excel",
                        title: 'Additions Right of Use Asset '  + end_date,
                        className: "btn-sm btn-primary-variant-one",
                        footer: true
                    },
                    {
                        extend: "pdfHtml5",
                        orientation: 'landscape',
                        title: 'Additions Right of Use Asset '  + end_date,
                        className: "btn-sm btn-primary-variant-one",
                        footer: true
                    },
                    {
                        extend: "print",
                        title: 'Additions to Lease Liability '  + end_date,
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