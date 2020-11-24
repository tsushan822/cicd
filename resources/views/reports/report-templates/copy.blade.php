@extends('layouts.master')
@section('content')
            {!! Form::open(['route' => 'report-templates.store', 'class' => 'form-horizontal']) !!}
            @include ('reports.report-templates.partials._copy_form',['addOrEditText' => 'Add New','disabled' => false])
            {!! Form::close() !!}

@stop
@section('javascript')
    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="/js/vendor/jquery-ui.min.js"></script>
    <script src="{{ mix('/js/custom/deals.js') }}"></script>
    <script>
        $('#report_template_table').dataTable({
            dom: 'Bfrtip',
            "aLengthMenu": [[25, 50, 100, 200, 500, -1], [25, 50, 100, 200, 500, "All"]],
            "iDisplayLength": 100,
            buttons: [
                'copy', 'excel', 'pdf', 'pageLength'
            ],
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        $(document).ready(function () {
            $('tbody').sortable({
                axis: 'y',
                stop: function (event, ui) {
                }

            });
        });

    </script>
@stop