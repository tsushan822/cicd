@extends('layouts.master')
@section('content')
    {!!Form::open(['route'=>'post.reporting.facility-overview','data-parsley-validate class'=>'form-horizontal
    form-label-left','id'=>'vueForm']) !!}
    @include('sub-views.reportForm',['model' => 'lease','StartEndOrReportDate'=>'ReportDate','title'=> Lang::get('master.Facility overview report')])
    {!!Form::close()!!}
    @include('reports.lease.table.facility-overview-table')
@stop

@push('form-js')

    <script>
        var allTranslation = "{!! __('master.All') !!}";

        $(document).ready(function () {
            var start_date = $("#end_date").val();
            var table = $.when($('#datatable-facility-overview').dataTable({
                "aLengthMenu": [[10, 25, 50, 200, 500, -1], [10, 25, 50, 200, 500, "All"]],
                "iDisplayLength": 25,
                dom: 'Bfrtip',
                "scrollX": true,
                buttons: [
                    {
                        extend: "copy",
                        title: 'Lease Facility overview report ' + start_date,
                        className: "btn-sm btn-primary-variant-one"
                    },
                    {
                        extend: "csv",
                        title: 'Lease Facility overview report ' + start_date,
                        className: "btn-sm btn-primary-variant-one",
                        footer: true
                    },
                    {
                        extend: "excel",
                        title: 'Lease Facility overview report ' + start_date,
                        className: "btn-sm btn-primary-variant-one",
                        footer: true
                    },
                    {
                        extend: "print",
                        title: 'Lease Facility overview report ' + start_date,
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