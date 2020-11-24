@extends('layouts.master')
@section('css')
@stop
@section('content')
    {!!Form::open(['route'=>'post.lease.summary','data-parsley-validate class'=>'form-horizontal form-label-left','id'=>'vueForm']) !!}
    @include('sub-views.reportForm',['model' => 'lease','StartEndOrReportDate'=>'StartWithMonth','title'=> Lang::get('master.Lease summary report'),'currency_is_required'=>'1'])
    {!!Form::close()!!}
    @include('reports.lease.table.lease-summary-table')
@stop

@section('javascript')

    <script>
        $(document).ready(function () {
            var end_date = $("#end_date").val();
            var table = $('#datatable-summary-lease').dataTable({
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "iDisplayLength": 25,
                dom: 'Bfrtip',
                "order": [],
                buttons: [
                    {
                        extend: "copy",
                        title: 'Lease Summary ' + end_date,
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        title: 'Lease Summary ' + end_date,
                        className: "btn-sm",
                        footer: true
                    },
                    {
                        extend: "excel",
                        title: 'Lease Summary ' + end_date,
                        className: "btn-sm",
                        footer: true
                    },
                    {
                        extend: "pdfHtml5",
                        orientation: 'landscape',
                        title: 'Lease Summary ' + end_date,
                        className: "btn-sm",
                        footer: true
                    },
                    {
                        extend: "print",
                        title: 'Lease Summary ' + end_date,
                        className: "btn-sm"
                    },
                    {
                        extend: "pageLength",
                        className: "btn-sm"
                    }
                ]
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
@stop

@push('form-js')

    <script>
        var allTranslation = "{!! __('master.All') !!}";

        $(document).ready(function () {
            var end_date = $("#end_date").val();
            var table = $.when($('#datatable-summary-lease').dataTable({
                "aLengthMenu": [[25, 50, 100, 200, 500, -1], [25, 50, 100, 200, 500, allTranslation]],
                "iDisplayLength": 50,
                "order": [] ,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: "copy",
                        className: "buttons-copy btn  btn-sm  btn-primary-variant-one  px-2 waves-effect  waves-effect "
                    },
                    {
                        extend: "csv",
                        className: "buttons-csvbtn  btn-sm  btn-primary-variant-one  px-2 waves-effect  waves-effect"
                    },
                    {
                        extend: "excel",
                        className: "buttons-excel btn  btn-sm  btn-primary-variant-one  px-2 waves-effect  waves-effect"
                    },
                    {
                        extend: "print",
                        className: "buttons-print btn  btn-sm  btn-primary-variant-one  px-2 waves-effect  waves-effect"
                    }
                ],
                stateSave: true,
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