<div class="lease_ui_block ">
    <div class="row">
        <div class="col-md-12 col-sm-12 mt-1">
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!!Form::select('agreement_type', ['Fixed term'=>trans('master.Fixed term'), 'Valid until further notice' => trans('master.Valid until further notice')] ,null,
                    ['class'=>'mdb-select   md-form'])!!}
                    {!!Form::label('agreement_type', trans('master.Agreement type'))!!}
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!!Form::input('text','contracts_first_possible_termination_day',null, array("id"=>"contracts_first_possible_termination_day", "class"=>"datepicker form-control date","placeholder" => Lang::get('master.yyyy-mm-dd')))!!}
                    {!!Form::label('contracts_first_possible_termination_day',trans('master.Contracts first possible termination day'))!!}
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!!Form::number('notice_period_in_months',null,['class'=>'form-control ','id'=>'notice_period_in_months', 'onkeypress'=>"return event.charCode >= 48 && event.charCode <= 57",'placeholder'=>'0','pattern'=>"[0-9]",'min'=>'0'])!!}
                    {!!Form::label('notice_period_in_months',
            trans('master.Notice period in months'))!!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="lease_ui_block ">
    <div class="row">
        <div class="col-md-12 col-sm-12 mt-1">
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!!Form::input('text','lease_end_date',null, array("id"=>"lease_end_date", "class"=>"datepicker form-control date","placeholder" => Lang::get('master.yyyy-mm-dd')))!!}
                    {!!Form::label('lease_end_date',trans('master.Lease end date'))!!}
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!! Form::input('text', 'square_metres',null, array("id"=>"square_metres",'placeholder'=>'0.00',"class"=>"dealform form-control currency")) !!}
                    {!!Form::label('square_metres',trans('master.Square metres'))!!}
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!! Form::input('text', 'grained_surface_area',null, array("id"=>"grained_surface_area",'placeholder'=>'0.00',"class"=>"dealform form-control currency")) !!}
                    {!!Form::label('grained_surface_area',trans('master.Grained surface area'))!!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="lease_ui_block ">
    <div class="row">
        <div class="col-md-12 col-sm-12 mt-1">
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!! Form::number('number_of_employees',null, array("id"=>"number_of_employees",'onkeypress'=>"return event.charCode >= 48 && event.charCode <= 57",'placeholder'=>'0','pattern'=>"[0-9]",'min'=>'0',"class"=>"dealform form-control")) !!}
                    {!!Form::label('number_of_employees',trans('master.Number of employees'))!!}
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                {!! Form::number('number_of_workstations',null, array("id"=>"number_of_workstations", 'onkeypress'=>"return event.charCode >= 48 && event.charCode <= 57",'placeholder'=>'0','pattern'=>"[0-9]",'min'=>'0',"class"=>" form-control")) !!}
                {!!Form::label('number_of_workstations',trans('master.Number of workstations'))!!}
                </div>
                </div>
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!! Form::number('parking_cost_per_month',null, array("id"=>"parking_cost_per_month",
                   'placeholder'=>'0', "class"=>" form-control",'placeholder'=>'0.00','pattern'=>"[0-9]",'min'=>'0')) !!}
                    {!!Form::label('parking_cost_per_month',trans('master.Parking cost per month'))!!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="lease_ui_block ">
    <div class="row">
        <div class="col-md-12 col-sm-12 mt-1">
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!! Form::number( 'number_of_parking_spaces',null, array("id"=>"number_of_parking_spaces",
                  'onkeypress'=>"return event.charCode >= 48 && event.charCode <= 57",'placeholder'=>'0','pattern'=>"[0-9]",'min'=>'0',"class"=>"dealform form-control")) !!}
                    {!!Form::label('number_of_parking_spaces',trans('master.Number of parking spaces'))!!}
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!! Form::input('text', 'capital_rent_per_month',null, array("id"=>"capital_rent_per_month",
                  "class"=>"dealform form-control currency",'placeholder'=>'0.00')) !!}
                    {!!Form::label('capital_rent_per_month',trans('master.Capital rent per month (rent/m2)'))!!}
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!! Form::input('text', 'maintenance_rent_per_month',null, array("id"=>"maintenance_rent_per_month",
                   "class"=>"dealform form-control currency",'placeholder'=>'0.00')) !!}
                    {!!Form::label('maintenance_rent_per_month',trans('master.Maintenance rent per month (rent/m2)'))!!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="lease_ui_block ">
    <div class="row">
        <div class="col-md-12 col-sm-12 mt-1">
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!! Form::input('text', 'other_cost_per_month',null, array("id"=>"other_cost_per_month",
                   "class"=>"dealform form-control currency",'placeholder'=>'0.00')) !!}
                    {!!Form::label('other_cost_per_month',trans('master.Other cost per month'))!!}
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!! Form::input('text', 'total_costs_affecting_rent',null, array("id"=>"total_costs_affecting_rent",
                  "class"=>"dealform form-control currency")) !!}
                    {!!Form::label('total_costs_affecting_rent',trans('master.Total costs affecting rent'))!!}
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!! Form::input('text', 'renovation_and_rent_free_periods',null, array("id"=>"renovation_and_rent_free_periods",
                   "class"=>"dealform form-control","placeholder"=>'')) !!}
                    {!!Form::label('renovation_and_rent_free_periods',trans('master.Renovation and rent free periods'))!!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="lease_ui_block ">
    <div class="row">
        <div class="col-md-12 col-sm-12 mt-1">
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!!Form::input('text','rent_security_expiry_date',null, array("id"=>"rent_security_expiry_date", "class"=>"datepicker form-control date","placeholder" => Lang::get('master.yyyy-mm-dd')))!!}
                    {!!Form::label('rent_security_expiry_date',trans('master.Rent security expiry date'))!!}
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!!Form::select('rent_security_type', [
                   'No security needed' => trans('master.No security needed'),
                   'Paid rent guarantees (in cash)'=>trans('master.Paid rent guarantees (in cash)'),
                   'Bank guarantee, parent company'=>trans('master.Bank guarantee, parent company'),
                   'Bank guarantee, other company' => trans('master.Bank guarantee, other company'),
                   'Other security' => trans('master.Other security')] ,null,
                   ['class'=>'mdb-select   md-form','id'=>'rent_security_type'])!!}
                    {!!Form::label('rent_security_type',trans('master.Rent security type'))!!}
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!!Form::select('rent_security_received_back', [0=>trans('master.No'), 1 => trans('master.Yes')]
                   ,null,['class'=>'mdb-select   md-form','id'=>'rent_security_received_back'])!!}
                    {!!Form::label('rent_security_received_back',trans('master.Rent security received back'))!!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="lease_ui_block ">
    <div class="row">
        <div class="col-md-12 col-sm-12 mt-1">
            <div class="col-md-4 col-sm-12">
                <div class="md-form ">
                    {!!Form::select('show_agreement_in_report', [1 => trans('master.Yes'),0=>trans('master.No')],null,
                  ['class'=>'mdb-select   md-form','id'=>'show_agreement_in_report'])!!}
                    {!!Form::label('show_agreement_in_report',trans('master.Show agreement in report'))!!}
                </div>
            </div>
        </div>
    </div>
</div>