@extends('layouts.master')
@section('css')
@stop
@section('content')
    {!!Form::open(['route'=>'get.trezone-api.index','class'=>'form-horizontal form-label-left',
    'method' => 'get'])
     !!}
    <div class="col-md-4 col-sm-12 col-xs-12">
        <h3>{!! trans('master.Trezone API Integration')!!}</h3>
        <small>
            <span class="required">*</span> @lang('master.indicates required fields')
        </small>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12">
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="btn btn-app" href="/">
                    <i class="fas fa-arrow-left"></i> @lang('master.Home')
                </a></li>
            <li>
                <button class="btn btn-app" type="submit" value="submit" name="submit"><i
                            class="glyphicon glyphicon-eye-open"></i>
                    @lang('master.Show')
                </button>
            </li>
        </ul>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 ln_solid"></div>

    <div class="col-md-12 col-sm-12 col-xs-12 form_outher_layer">
        <div class="form-group">
            <label class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-12"> {!!Form::label('entity_id', Lang::get('master.Entity'))!!}</label>
            <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
                {!!Form::select('entity_id[]', $entities,request('entity_id'),['id' => 'entity_id','class'=>'js-multiselect
                form-control','multiple' => 'multiple'])!!}
            </div>
            <label class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-12 "> {!!Form::label('counterparty_id', Lang::get('master.Counterparty'))!!}</label>
            <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
                {!!Form::select('counterparty_id[]',$counterparties,request('counterparty_id'), array("id"=>"counterparty_id", 'multiple' =>
                'multiple',"class"=>"js-multiselect form-control"))!!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 form_outher_layer">
        <div class="form-group">
            <label class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-12"> {!!Form::label('portfolio_id', Lang::get('master.Portfolio'))!!}</label>
            <div class=" col-lg-5 col-md-4 col-sm-4 col-xs-12">
                {!!Form::select('portfolio_id[]', $portfolios,request('portfolio_id'),['id' => 'portfolio_id','multiple' => 'multiple',
                'class'=>'js-multiselect  form-control'])!!}
            </div>
            <label class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-12 "> {!!Form::label('cost_center_id', Lang::get('master.Cost center'))!!}
            </label>
            <div class=" col-lg-5 col-md-4 col-sm-4 col-xs-12">
                {!!Form::select('cost_center_id[]',$costCenters,request('cost_center_id'), array("id"=>"cost_center_id",'multiple' =>
                'multiple', "class"=>"js-multiselect form-control"))!!}
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 form_outher_layer">
        <div class="form-group">
            <label class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-12"> {!!Form::label('start_date', Lang::get('master.Start date'))!!}
                <span class="required">*</span></label>
            <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
                {!!Form::input('text','start_date',request('start_date'), array("id"=>"start_date",
                "class"=>"datepicker form-control
                date","placeholder" => "yyyy-mm-dd"))!!}
            </div>
            <label class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-12 ">   {!!Form::label('end_date', Lang::get('master.End date'))!!}
                <span class="required">*</span>
            </label>
            <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
                {!!Form::input('text','end_date',request('end_date'), array("id"=>"end_date", "class"=>"datepicker
                form-control date",
                "placeholder" => "yyyy-mm-dd"))!!}
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 form_outher_layer">
        <div class="form-group">
            <label class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-12"> {!!Form::label('module_id', Lang::get
            ('master.Module'))!!}</label>
            <div class=" col-lg-5 col-md-4 col-sm-4 col-xs-12">
                {!!Form::select('module_id[]', $modules,request('module_id'),['id' => 'module_id','multiple' =>
                'multiple',
                'class'=>'js-multiselect  form-control'])!!}
            </div>
        </div>
    </div>

    {!!Form::close()!!}
    <div class="col-md-12 col-sm-12 col-xs-12 ln_solid"></div>

    <table id="datatable-trezone"
           class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th>{{trans('master.Unit')}}</th>
            <th>{{trans('master.Counterparty code')}}</th>
            <th>{{trans('master.Counterparty name')}}</th>
            <th>{{trans('master.Date')}}</th>
            <th>{{trans('master.Amount')}}</th>
            <th>{{trans('master.Currency')}}</th>
            <th>{{trans('master.Portfolio')}}</th>
            <th>{{trans('master.Account')}}</th>
            <th>{{trans('master.Counter account')}}</th>
            <th>{{trans('master.Reference code')}}</th>
            <th>{{trans('master.Description')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($returnValues))
            @foreach($returnValues as $value)
                <tr>
                    <td>{{ $value['unit_code'] }}</td>
                    <td>{{ $value['counterparty_code'] }}</td>
                    <td>{{ $value['counterparty_name'] }}</td>
                    <td>{{ $value['date'] }}</td>
                    <td>{{ mYFormat($value['amount']) }}</td>
                    <td>{{ $value['currency'] }}</td>
                    <td>{{ $value['portfolio'] }}</td>
                    <td>{{ $value['account'] }}</td>
                    <td>{{ $value['counter_account'] }}</td>
                    <td>{{ $value['reference_code'] }}</td>
                    <td>{{ $value['description'] }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
@stop
@section('javascript')

    <script>
        $(document).ready(function () {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var table = $('#datatable-trezone').dataTable({
                "aLengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                "iDisplayLength": 25,
                dom: 'Bfrtip',
                "order": [[3, "asc"]],
                buttons: [
                    {
                        extend: "csv",
                        title: 'LeaseAccounting ' + start_date + ' ' + end_date,
                        className: "btn-lg",
                        footer: true
                    },
                    {
                        extend: "excel",
                        title: 'LeaseAccounting  ' + start_date + ' ' + end_date,
                        className: "btn-lg",
                        footer: true
                    }
                ]
            });
        });
    </script>
    <script>

        // For Multiselect
        $(document).ready(function () {
            $('.js-multiselect').select2({
                placeholder: "{{Lang::get('master.Select (Optional)')}}",
                closeOnSelect: false
            });
        });
        // For CCY
        $(document).ready(function () {
            $('.js-singleselect').select2({
                placeholder: "{{Lang::get('master.Select (Optional)')}}"
            });
        });
    </script>
@stop