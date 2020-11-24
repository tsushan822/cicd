@extends('layouts.master')
@section('css')

@stop
@section('content')
    {!!Form::open(['route'=>'post.audit-trail.report','data-parsley-validate class'=>'form-horizontal form-label-left']) !!}

    <div class="col-md-8 col-sm-8 col-xs-12">
        <h3> Audit Trail Report</h3>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 ln_solid"></div>
    <div class="col-md-3 col-sm-4 col-xs-12">

        <div class="form-group">
            <label class="control-label col-md-6 col-sm-6 col-xs-12">   {!!Form::label('accounting_start_date', 'Report Start Date')!!}
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                {!!Form::input('text','accounting_start_date',null, array("id"=>"accounting_start_date", "class"=>"datepicker form-control date","placeholder" => "yyyy-mm-dd"))!!}
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-6 col-sm-6 col-xs-12">   {!!Form::label('accounting_end_date', 'Report End Date')!!}
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                {!!Form::input('text','accounting_end_date',null, array("id"=>"accounting_end_date", "class"=>"datepicker form-control date","placeholder" => "yyyy-mm-dd"))!!}
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-6 col-sm-6 col-xs-12">
                {!!Form::label('user_id', 'User')!!}
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                {!!Form::select('user_id', $users, null, ['class'=>'form-control','placeholder' => 'Choose User'])!!}
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-6 col-sm-6 col-xs-12">
                {!!Form::label('model', 'Model')!!}
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                {!!Form::select('model', ['Lease' => 'Leasing','MmDeal' => 'Loans','FxDeal' => 'FX','Guarantee' => 'Guarantees'], null, ['class'=>'form-control','placeholder' => 'Choose Model'])!!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="btn btn-app" href="/"><i class="fas fa-arrow-left"></i>@lang('master.Back')</a></li>
                    <li>
                        <button class="btn btn-app" type="submit" value="Submit" name="submit"><i class="fa fa-eye"></i>
                            Show
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {!!Form::close()!!}

    @if(isset($startDate))
        <table id="audit-trail-report" class="table  dt-responsive " width="100%">
            <thead>
            <tr>
                <th>User</th>
                <th>Model</th>
                <th>Event</th>
                <th>Table Id</th>
                <th>Item</th>
                <th>Value before</th>
                <th>Value after</th>
                <th>When</th>
                <th>Date Time</th>
                <th>Timezone</th>
            </tr>
            </thead>
            <tbody>
            @foreach($changes as $change)
                <tr>
                    <td>{!!$change['user']!!}</td>
                    <td>{!!$change['model']!!}</td>
                    <td>{!!$change['event']!!}</td>
                    <td>{!!$change['table_id']!!}</td>
                    <td>{!!$change['title']!!}</td>
                    <td>{!! !is_numeric($change['before']) ?$change['before'] :number_format($change['before'],5) !!}</td>
                    <td>{!! !is_numeric($change['after']) ? $change['after']:number_format($change['after'],5) !!}</td>
                    <td>{!! $change['time']->diffForHumans() !!} </td>
                    <td>{!! $change['time']->toDateTimeString() !!}</td>
                    <td>{!! $change['time']->getTimezone()->getName() !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@stop

@section('javascript')
    <script>
        $(document).ready(function () {
            var table = $('#audit-trail-report').dataTable({
                "oLanguage": {
                    "sUrl": "/languages/dataTables.{!! Auth::user()->locale;!!}.txt"
                },
                "aLengthMenu": [[50, 100, 200, 500, -1], [50, 100, 200, 500, "All"]],
                "order": [[8, "desc"]],
                "iDisplayLength": 50,
                dom: 'Bfrtip',
                buttons: [{
                    extend: "copy",
                    title: 'Loan Register',
                    className: "btn-sm"
                },
                    {
                        extend: "csv",
                        title: 'Audit Trail Report',
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        title: 'Audit Trail Report',
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        title: 'Audit Trail Report',
                        className: "btn-sm",
                        pageSize: 'LEGAL'
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                    {
                        extend: "pageLength",
                        className: "btn-sm"
                    }],
                stateSave: true,

            });
        });
    </script>
@stop