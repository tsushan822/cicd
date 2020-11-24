<div class="pb-4 ">

    <div class=" px-1 cardSimiliarShadow bg-white">


        <!--Section: Content-->
        <section class="dark-grey-text px-2 ">
            <div class="headingandbuttons  px-0 py-2 borderRemoval boxShadowRemoval">
                <div class="d-flex justify-content-between">
                    <div class=" d-flex align-items-center">
                        <div class="pageTitleAndinfo  w-100 text-left">
                            @if(isset($copy))
                                @includeIf('sub-views.createdByUserText',['deal' => $lease,'copy' => $copy, 'type'=> Lang::get('master.Lease agreement')])
                            @elseif(isset($lease))
                                @includeIf('sub-views.createdByUserText',['deal' => $lease, 'type'=> Lang::get('master.Lease agreement')])
                            @else
                                @includeIf('sub-views.createdByUserText',['type'=> Lang::get('master.Lease agreement')])
                            @endif
                                <small class="">
                                    <span class="required text-danger">*</span> indicates required fields
                                </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center zen_tab">

                    </div>
                    <div class="d-flex align-items-center" id="datatable-buttons">
                        <div>

                            @if($addOrEditText == 'Edit')
                                @if($buttonShow['copy'])

                                    <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light"
                                       href="{!! route('leases.copy', $lease->id) !!}">
                                        <i class="fas  fa-clone "></i>
                                        @lang('master.Copy')

                                    </a>

                                @endif

                                @if($buttonShow['delete'])


                                    <a class="btn btn-sm  btn-primary-variant-alert  px-2 waves-effect waves-light"
                                       href="{!! route('leases.show', $lease->id) !!}">
                                        <i class="far  fa-minus-square "></i>
                                        @lang('master.Delete')

                                    </a>


                                @endif
                                @if($buttonShow['save'])

                                    <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"
                                            type="submit"
                                            value="Save"
                                            id="register_submit"><i
                                                class="fas  fa-save "></i>
                                        @lang('master.Save')

                                    </button>

                                @endif
                            @else
                                @if($buttonShow['add'])

                                    <button class="btn btn-sm btn-primary-variant-main  px-2 waves-effect waves-light"
                                            type="submit"
                                            value="Save"
                                            id="register_submit"><i
                                                class="fas  fa-save"></i>
                                        @lang('master.Add new')
                                    </button>



                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav ml-2 mr-2 nav-tabs" role="tablist">

                @if(isset($lease) && !isset($copy))
                    <li class="nav-item">
                        <a class="nav-link borderRadiusRemoval {{ ( isset($lease))? 'active' : ''}}" data-toggle="tab"
                           href="#leaseflows" role="tab">
                            @lang('master.FLOWS')
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link borderRadiusRemoval {{ ( !isset($lease) || isset($copy))? 'active' : ''}}"
                       data-toggle="tab" href="#essential" role="tab">
                        @lang('master.DETAILS')
                    </a>
                </li>

                @if(!isset($copy))
                    <li class="nav-item">
                        <a class="nav-link borderRadiusRemoval" data-toggle="tab" href="#additional" role="tab">
                            @lang('master.ADDITIONAL')</a>
                    </li>

                    <li class="nav-item">
                        @if( $buttonShow['attachments'])
                            <a class="nav-link borderRadiusRemoval" data-toggle="tab" href="#attachment" role="tab">
                                @lang('master.ATTACHMENTS')</a>
                        @endif
                    </li>

                    <li class="nav-item">
                        @if(isset($lease) && count($leaseFlows))
                            <a class="nav-link borderRadiusRemoval" data-toggle="tab" href="#leasechange" role="tab">
                                @lang('master.CHANGES')</a>
                        @endif
                    </li>
                    @if(!isset($buttonShow['facility_overview']))
                        <li class="nav-item"><a class="nav-link borderRadiusRemoval" data-toggle="tab"
                                                href="#facilityTab" role="tab">@lang('master.FACILITY MANAGEMENT')</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        @if($buttonShow['audit_trail'])
                            <a class="nav-link borderRadiusRemoval" data-toggle="tab" href="#audit_trail"
                               id="audittrail-tab" role="tab"> AUDIT TRAIL </a>
                        @endif
                    </li>

                    <li class="nav-item">
                        @if( $buttonShow['cost_center_split'])
                            <a class="nav-link " data-toggle="tab" id="cost_center_split_tab"
                               href="#cost-center-split" role="tab">
                                @lang('master.COST-CENTER SPLIT')
                            </a>
                        @endif
                    </li>

                @endif


            </ul>

            <div class="classic-tabs mx-2">


                <!--Grid row-->


                <!-- Pills navs -->


                <!-- Pills panels -->
                <div class="tab-content card boxShadowRemoval borderRemoval pt-1">
                    <div class="text-center" id="form-error-alert">
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true"
                             style="margin-left: auto;" data-autohide="false">
                            <div class="toast-header">
                                <svg class="rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                                     preserveAspectRatio="xMidYMid slice"
                                     focusable="false" role="img">
                                    <rect class="toast-danger" fill="red" width="100%" height="100%"/>
                                </svg>
                                <strong class="mr-auto">@lang('Error')</strong>
                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="toast-body">
                                @lang('Required inputs are missing')
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane  fade in show {{ ( !isset($lease) || isset($copy))? 'active' : ''}}"
                         id="essential" role="tabpanel">


                        <div class=" borderRemoval">
                            <div class="lease_ui_block">
                                <div class="row pb-0">

                                    <div class="col-md-12  col-sm-12 mt-3">
                                        <div class="col-md-4">
                                            {!!Form::select('entity_id', $entities ,null,["id"=>"entity_id",'class'=>'mdb-select   md-form ','placeholder' => Lang::get('master.Choose entity')])!!}
                                            {!!Form::label('entity_id', 'Entity<span class="text-danger">*</span>',[],false)!!}
                                        </div>
                                        <div class="col-md-4">
                                            {!!Form::select('counterparty_id', $counterparties ,null,
                                            ['class'=>'mdb-select   md-form ', 'placeholder' => Lang::get('master.Choose counterparty'),'id' => 'counterparty_id'])!!}
                                            {!!Form::label('counterparty_id','Counterparty<span class="text-danger">*</span>',[],false)!!}
                                        </div>
                                        <div class="col-md-4">
                                            {!!Form::select('lease_type_id', $leaseTypes,null,
                                            ['class'=>'mdb-select   md-form ','id'=>'lease_type_id', 'placeholder' => Lang::get('master.Choose')])!!}
                                            {!!Form::label('lease_type_id','Lease type<span class="text-danger">*</span>',[],false)!!}
                                        </div>

                                        <div class="col-md-4">
                                            @if($buttonShow['cost_center'])
                                                {!!Form::select('cost_center_id', $costCenters ,null,['id'=>'cost_center_id',
                                                'class'=>'mdb-select   md-form ','placeholder'=>Lang::get('master.Select (Optional)')])!!}
                                                {!!Form::label('cost_center_id', Lang::get('master.Cost center'))!!}
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            {!!Form::select('portfolio_id', $portfolios ,null,['class'=>'mdb-select
                                            md-form ','placeholder' => Lang::get('master.Choose'),'id'=>'portfolio_id'])!!}
                                            {!!Form::label('portfolio_id','Portfolio<span class="text-danger">*</span>',[],false)!!}
                                        </div>

                                        <div class="col-md-4">
                                            <div class="md-form ">
                                                {!! Form::input('text', 'lease_rate',null, array("id"=>"lease_rate",'placeholder'=>'0.00',"class"=>"form-control currencyNonNegative", "disabled" => $disabled['single'])) !!}
                                                {!!Form::label('lease_rate', 'Interest rate<span class="text-danger">*</span>',[],false)!!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form ">
                                                {!! Form::input('text', 'customer_reference',null, array("id"=>"customer_reference",'placeholder'=>Lang::get('master.Customer reference'),"class" =>"form-control")) !!}
                                                {!!Form::label('customer_reference', Lang::get('master.Customer reference'))!!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            @if($addOrEditText == 'Edit')
                                                {!! Form::hidden('currency_id',$lease->currency_id) !!}
                                            @endif
                                            {!! Form::select('currency_id',$currencies ,null,array("id"=>"currency_id","class"=>"mdb-select   md-form  short","placeholder" => Lang::get('master.CCY')))!!}
                                            {!! Form::label('currency_id', 'Currency<span class="text-danger">*</span>',[],false) !!}
                                        </div>
                                        {!! Form::input('text','ifrs_accounting',0, ['disabled'=>$disabled['single'],'style' => 'display:none'])!!}

                                        <div class="col-md-4">
                                            <div class="form-check pl-0 text-left mt-4">
                                                {!! Form::input('text','ifrs_accounting',0, ['disabled'=>$disabled['single'],'style' => 'display:none'])!!}
                                                {!! Form::checkbox('ifrs_accounting',1, 1, ['id'=>'ifrs_accounting',
                                                'class'=>'form-check-input', 'type'=>'checkbox','disabled'=>$disabled['single']])!!}
                                                {!! Form::label('ifrs_accounting', trans('master.Calculate balance sheet values'),array("class"=>"form-check-label" ))!!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lease_ui_block">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4  col-sm-12 ">
                                        <div>
                                            <div class="md-form ">
                                                {!!Form::input('text','effective_date',null, array("id"=>"effective_date", "class"=>"datepicker form-control date","placeholder" => Lang::get('master.yyyy-mm-dd')))!!}
                                                {!!Form::label('effective_date', 'Commencement date<span class="text-danger">*</span>',[],false)!!}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="md-form ">
                                                {!!Form::input('text','maturity_date',null, array("id"=>"maturity_date", "class"=>"datepicker form-control date","placeholder" => Lang::get('master.yyyy-mm-dd')))!!}
                                                {!!Form::label('maturity_date','End date<span class="text-danger">*</span>',[],false) !!}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="md-form ">
                                                {!!Form::input('text','contractual_end_date',null, array("id"=>"contractual_end_date","placeholder" => Lang::get('master.yyyy-mm-dd'),"class"=>"datepicker form-control date"))!!}
                                                {!!Form::label('contractual_end_date', 'Contractual end date<span class="text-danger">*</span>',[],false)!!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4  col-sm-12 ">
                                        <div>
                                            <div class="md-form ">
                                                {!!Form::input('text','first_payment_date',null, array("id"=>"first_payment_date", "class"=>"datepicker form-control date","placeholder" => Lang::get('master.yyyy-mm-dd')))!!}
                                                {!!Form::label('first_payment_date',  'First payment month<span class="text-danger">*</span>',[],false)!!}
                                            </div>
                                        </div>
                                        <div>
                                            {!!Form::select('lease_flow_per_year',[1=>1,2=>2,3=>3,4=>4,6=>6,12=>12],null, array("id"=>"lease_flow_per_year", "class"=>"mdb-select   md-form ","disabled" => $disabled['double']))!!}
                                            {!!Form::label('lease_flow_per_year', 'Payments per year<span class="text-danger">*</span>',[],false)!!}
                                        </div>
                                        <div>
                                            {!!Form::select('payment_day', $paymentDays ,null,array("id"=>"payment_day","class"=>"mdb-select   md-form "))!!}
                                            {!!Form::label('payment_day', 'Payment day<span class="text-danger">*</span>',[],false)!!}
                                        </div>
                                    </div>
                                    <div class="col-md-4  col-sm-12 ">
                                        <div>
                                            <div class="md-form ">
                                                {!! Form::input('text', 'lease_amount',null, array("id"=>"lease_amount",'placeholder'=>'0.00',"class"=>"dealform form-control currency","disabled" => $disabled['double'])) !!}
                                                {!! Form::label('lease_amount','Fixed asset lease amount<span class="text-danger">*</span>',[],false) !!}
                                            </div>
                                        </div>


                                        <div>
                                            <div class="md-form ">
                                                {!! Form::input('text', 'lease_service_cost',null, array
                                                ("id"=>"lease_service_cost","class"=>"dealform form-control
                                                currency",'placeholder'=>'0.00',"disabled" => $disabled['double'])) !!}
                                                {!!Form::label('lease_service_cost', Lang::get('master.Services included in lease'))!!}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="md-form ">
                                                {!!
                                                Form::input('text', 'total_lease',null, array("id"=>"total_lease","class"=>"dealform form-control currency",'placeholder'=>'0.00',"readonly" =>"true","disabled" => $disabled['double']))
                                                !!}
                                                {!!Form::label('total_lease', Lang::get('master.Total lease payment'))!!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lease_ui_block">
                            <div class="row">
                                {{-- <div class="col-md-4 col-sm-6 d-flex flex-column justify-start">
                                     <h1 class="mt-3 title">{{trans('master.Additions to Lease liability and Right of Use Asset')}}</h1>
                                 </div>--}}
                                <div class="col-md-12  col-sm-12 mt-1">
                                    <ul class="nav lease_pills md-pills ">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#panel11"
                                               role="tab">{{trans('master.Lease Liability')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#panel12"
                                               role="tab">{{trans('master.Right-of-Use Asset')}}</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panels -->
                                    <div class="tab-content pt-0">

                                        <!--Panel 1-->
                                        <div class="tab-pane fade in show active" id="panel11" role="tabpanel">

                                            <div class="col-md-4 pl-0">
                                                <div class="md-form ">
                                                    {!! Form::input('text', 'residual_value_guarantee',null, array("id"=>"residual_value_guarantee",'placeholder'=>'0.00',"class"=>"dealform  paddingtopfixerlease form-control currency","disabled" => $disabled['single'])) !!}
                                                    {!!Form::label('residual_value_guarantee', Lang::get('master.Residual value guarantee'))!!}
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-0">
                                                <div class="md-form ">
                                                    {!! Form::input('text', 'penalties_for_terminating',null, array("id"=>"penalties_for_terminating",'placeholder'=>'0.00',"class"=>"dealform paddingtopfixerlease form-control currency","disabled" => $disabled['single'])) !!}
                                                    {!!Form::label('penalties_for_terminating', Lang::get('master.Penalties for terminating the lease')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-0">
                                                <div class="md-form ">
                                                    {!! Form::input('text', 'exercise_price',null, array("id"=>"exercise_price",'placeholder'=>'0.00',"class"=>"dealform form-control paddingtopfixerlease currency", "disabled" => $disabled['single'])) !!}
                                                    {!! Form::label('exercise_price', Lang::get('master.Exercise price of a purchase option')) !!}
                                                </div>
                                            </div>

                                        </div>
                                        <!--/.Panel 1-->

                                        <!--Panel 2-->
                                        <div class="tab-pane fade" id="panel12" role="tabpanel">

                                            <div class="col-md-8 pl-0">
                                                <div class="md-form ">
                                                    {!! Form::input('text', 'payment_before_commencement_date',null, array("id"=>"payment_before_commencement_date",'placeholder'=>'0.00',"class"=>"dealform paddingtopfixerlease form-control currency","disabled" => $disabled['single'])) !!}

                                                    {!! Form::label('payment_before_commencement_date', Lang::get('master.Lease payments made on or before commencement date')) !!}

                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-0">
                                                <div class="md-form ">
                                                    {!! Form::input('text', 'initial_direct_cost',null, array("id"=>"initial_direct_cost",'placeholder'=>'0.00',"class"=>"dealform paddingtopfixerlease form-control currency","disabled" =>$disabled['single'])) !!}


                                                    {!!Form::label('initial_direct_cost', Lang::get('master.Initial direct cost'))!!}


                                                </div>
                                            </div>
                                            <div class="col-md-8 pl-0">
                                                <div class="md-form ">
                                                    {!! Form::input('text', 'cost_dismantling_restoring_asset',null, array("id"=>"penalties_for_terminating",'placeholder'=>'0.00',"class"=>"dealform  paddingtopfixerlease form-control currency","disabled" => $disabled['single'])) !!}
                                                    {!!Form::label('cost_dismantling_restoring_asset', Lang::get('master.Estimated cost for dismantling restoring asset'))!!}
                                                </div>
                                            </div>


                                            <div class="col-md-4 pl-0">
                                                <div class="md-form ">

                                                    {!! Form::input('text', 'lease_incentives_received',null, array("id"=>"lease_incentives_received",'placeholder'=>'0.00',"class"=>"dealform paddingtopfixerlease form-control currency","disabled" => $disabled['single'])) !!}
                                                    {!!Form::label('lease_incentives_received', Lang::get('master.Incentives received'))!!}

                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-0">
                                                <div class="md-form ">
                                                    {!! Form::input('text', 'residual_value',null, array("id"=>"residual_value","class"=>"dealform form-control currency paddingtopfixerlease",'placeholder'=>'0.00',"disabled" => $disabled['single'])) !!}
                                                    {!!Form::label('residual_value', Lang::get('master.Residual value'))!!}
                                                </div>
                                            </div>

                                        </div>
                                        <!--/.Panel 2-->

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane  fade in show {{ ( isset($lease) && !isset($copy))? 'active' : ''}}"
                         id="leaseflows" role="tabpanel">
                        @if(isset($lease))
                            @include('Lease.lease-flows.leaseflow_in_lease')
                        @endif
                    </div>
                    <div class="tab-pane  fade in show " id="additional" role="tabpanel">
                        <div class="card-deck ">
                            <div class="card borderRemoval boxShadowRemoval">
                                <div class="card-body px-0 py-0">
                                    <div class="d-flex flex-column h-100 justify-content-around align-items-start">
                                        <div class="form-check mt-2">
                                            {!! Form::hidden('is_archived', 0) !!}
                                            {!!Form::checkbox('is_archived',1, null, ['id'=>'is_archived', 'type'=>'checkbox','class'=>'form-check-input'])!!}
                                            {!!Form::label('is_archived', Lang::get('master.Move to archive before maturity'),array("class"=>"form-check-label" ))!!}
                                        </div>
                                        <div class="form-check mt-4">
                                            {!! Form::hidden('non_accountable', 0) !!}
                                            {!!Form::checkbox('non_accountable',1, null, ['id'=>'non_accountable',
                                            'type'=>'checkbox','class'=>'form-check-input'])!!}
                                            {!!Form::label('non_accountable', Lang::get('master.Excluded from Accounting and Reporting'),array("class"=>"form-check-label" ))!!}
                                        </div>
                                        <div class="form-check mt-4">
                                            {!! Form::hidden('calculate_valuation', 0) !!}
                                            {!!Form::checkbox('calculate_valuation',1, null,
                                            ['id'=>'calculate_valuation', 'type'=>'checkbox',
                                            'class'=>'form-check-input'])!!}
                                            {!!Form::label('calculate_valuation', Lang::get('master.Calculate Valuation'),array("class"=>"form-check-label" ))!!}
                                        </div>
                                        @if( $buttonShow['cost_center_split'])
                                            <div class="form-check mt-4">
                                                {!! Form::hidden('cost_center_split', 0) !!}
                                                {!!Form::checkbox('cost_center_split',1, null, ['id'=>'cost_center_split', 'type'=>'checkbox','class'=>'form-check-input'])!!}
                                                {!!Form::label('cost_center_split', trans('master.Cost center split'),array("class"=>"form-check-label" ))!!}

                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card borderRemoval boxShadowRemoval">
                                <div class="card-body px-0 py-0">
                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="col-md-12 mt-2">
                                                <div class="form-group shadow-textarea">
                                                    {!! Form::textarea('text', null, ['class' => 'form-control z-depth-1', 'rows' => 3, 'placeholder'=>'Text']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-12 d-none">
                                                <div class="md-form ">
                                                    {!! Form::text('internal_order', null, ['class' => 'form-control', 'placeholder'=>Lang::get('master.Internal order')]) !!}
                                                    {!!Form::label('internal_order', trans('master.Internal order'))!!}
                                                </div>
                                            </div>
                                            <div class="col-md-12 d-none">
                                                <div class="md-form ">
                                                    {!! Form::text('tax', null, ['class' => 'form-control', 'placeholder'=>Lang::get('master.Tax')]) !!}

                                                    {!!Form::label('tax',
                             trans('master.Tax'))!!}
                                                </div>
                                            </div>
                                            <div class="col-md-12 d-none">
                                                <div class="md-form ">
                                                    {!! Form::text('rou_asset_number', null, ['class' => 'form-control', 'placeholder'=>Lang::get('master.RoU asset number')]) !!}
                                                    {!!Form::label
                               ('rou_asset_number', trans('master.RoU asset number'))!!}
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane  fade in show " id="attachment" role="tabpanel">
                        <div class="card z-depth-0 border border-light rounded-0 unsetCardBorder">

                            <!--Card content-->
                            <div class="card-body">

                                <div>
                                    <div class="row">
                                        <!--Grid column-->
                                        <div class="col-md-4 mb-4">
                                            <div class="upload-button-wrapper">
                                                <img src="/img/copy.png" style="max-height: 300px"
                                                     class="img-fluid z-depth-1-half" alt="">
                                                <br/>
                                                @include('layouts.all.file_upload')

                                            </div>
                                        </div>
                                        <!--Grid column-->
                                        <div class="col-md-7 offset-md-1">
                                            @if(isset($lease))
                                                @include('layouts.all.file_display',['module'=>'Lease', 'files' => $files,'id' => $lease->id])
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($lease) && count($leaseFlows))
                        <div class="tab-pane  fade in show " id="leasechange" role="tabpanel">
                            @include('Lease.leases.extension')
                        </div>
                    @endif
                    @if($buttonShow['audit_trail'])
                        <div class="tab-pane  fade in show " id="audit_trail" role="tabpanel">
                            {!! Form::hidden('model_id', request()->segment(2),['id' => 'model_id']) !!}
                            {!! Form::hidden('model', 'Lease',['id' => 'model']) !!}
                            @include('layouts.all.ajax_audit_trail')
                        </div>
                    @endif
                    @if($buttonShow['cost_center_split'])
                        <div class="tab-pane  fade in show " id="cost-center-split" role="tabpanel">
                            @include('Lease.leases.cc-split')
                        </div>
                    @endif
                    @if(!isset($buttonShow['facility_overview']))
                        <div class="tab-pane  fade in show " id="facilityTab" role="tabpanel">
                            @include('Lease.leases.extra-field')
                        </div>
                    @endif
                </div>


        </section>
    </div>
</div>