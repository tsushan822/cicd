@javascript('lease', $lease)
@javascript('today', \Carbon\Carbon::today()->toDateString())
<!-- Modal -->
<div id="lease_changes_vue">
    <div class=" mt-2 border-light h-100">
        <div class="card borderRemoval mt-2 z-depth-0  rounded-0">

            <div class="card-body">

                <div class="form-row  d-none mb-4">
                    <div class="col-md-4 col-sm-12">
                        <div class="switch mt-3 d-flex">
                            <label>
                                {!!Form::checkbox('lease_extension',1, null, ['id'=>'lease_extension','v-model'=>'lease_extension', 'type'=>'checkbox'])!!}
                                <span class="lever "></span> {!!Form::label('lease_extension', Lang::get('master.Create change')) !!}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-8 mt-3 mb-5 d-flex justify-content-start align-item-start">
                        <div class="form-check form-check-inline">
                            {!!Form::radio('lease_extension_type', 'Increase In Scope', false, array('id'=>'increase_in_scope',':checked'=>'true','v-model'=>'lease_extension_type','type'=>'checkbox','class' => 'form-check-input lease_extension_type'))!!}
                            <label class="form-check-label"
                                   for="increase_in_scope">{{trans('master.Increase in scope / term')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            {!!Form::radio('lease_extension_type', 'Decrease In Scope', false, array('id'=>'decrease_in_scope','type'=>'checkbox','v-model'=>'lease_extension_type','class' => 'form-check-input lease_extension_type'))!!}
                            <label class="form-check-label"
                                   for="decrease_in_scope">{{trans('master.Decrease in scope')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            {!!Form::radio('lease_extension_type', 'Decrease In Term', false, array('id'=>'decrease_in_term','type'=>'checkbox','v-model'=>'lease_extension_type','class' => 'form-check-input lease_extension_type'))!!}
                            <label class="form-check-label"
                                   for="decrease_in_term">{{trans('master.Decrease in term')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            {!!Form::radio('lease_extension_type', 'Terminate Lease', false, array('id'=>'terminate_lease','type'=>'checkbox','v-model'=>'lease_extension_type','class' => 'form-check-input lease_extension_type'))!!}
                            <label class="form-check-label"
                                   for="terminate_lease">{{trans('master.Terminate lease')}}</label>
                        </div>
                    </div>


                </div>


                <div class="row">
                    <div class="col-md-3" @click="modalPopUp('Increase in scope / term','increase_in_scope')">
                        <div class="form_type">
                            <i class="fas fa-2x fa-plus"></i>
                            <p>{{trans('master.Increase in scope / term')}}</p>
                        </div>
                    </div>
                    <div class="col-md-3" @click="modalPopUp('Decrease in scope','decrease_in_scope')">
                        <div class="form_type">
                            <i class="fas fa-2x fa-plus"></i>
                            <p>{{trans('master.Decrease in scope')}}</p>
                        </div>
                    </div>
                    <div class="col-md-3" @click="modalPopUp('Decrease in term','decrease_in_term')">
                        <div class="form_type">
                            <i class="fas fa-2x fa-plus"></i>
                            <p>{{trans('master.Decrease in term')}}</p>
                        </div>
                    </div>
                    <div class="col-md-3" @click="modalPopUp('Terminate lease','terminate_lease')">
                        <div class="form_type">
                            <i class="fas fa-2x fa-plus"></i>
                            <p>{{trans('master.Terminate lease')}}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div v-show="showModal">

        <div class="modal  modal_lease_change right show  " id="exampleModalLongSC"
             :class="{'display-block':showModal,'fade':showModal}" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLongTitleSC" style="display: none;" aria-hidden="true">
            <div class="modal-dialog  modal-fluid modal-dialog-centered modal-dialog-scrollable" role="document" style="
    max-width: 1000px;
">
                <div class="modal-content" style="
    height: 600px;
">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitleSC" v-text="modalHeading"></h5>
                        <button @click="closeModal()" type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
              <span aria-hidden="true" style="
">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="lease_ui_block borderRemoval">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 mt-1">
                                    <div class="col-md-4 col-sm-12 col-sm-12">
                                        <div class="md-form ">
                                            {!!Form::input('text','date_of_change',\Carbon\Carbon::today()->toDateString(), array("id"=>"date_of_change",'v-model'=>'form.date_of_change', "class"=>"datepickerm form-control date","placeholder" => Lang::get('master.yyyy-mm-dd')))!!}
                                            {!!Form::label('date_of_change', Lang::get('master.Date of change'))!!}
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12" v-if="this.modalHeading !=='Terminate lease'">
                                        <div class="md-form ">
                                            {!!Form::input('text','extension_start_date',\Carbon\Carbon::today()->toDateString(), array("id"=>"extension_start_date",'v-model'=>'form.extension_start_date', "class"=>"datepickerm form-control date","placeholder" => Lang::get('master.yyyy-mm-dd')))!!}
                                            {!!Form::label('extension_start_date',  Lang::get('master.Effective start date'))!!}
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12" v-if="this.modalHeading!=='Terminate lease'">
                                        <div class="md-form ">
                                            {!!Form::input('text','extension_end_date',$lease->maturity_date, array("id"=>"extension_end_date", 'v-model'=>'form.extension_end_date',"class"=>"datepickerm form-control date","placeholder" => Lang::get('master.yyyy-mm-dd')))!!}
                                            {!!Form::label('extension_end_date', Lang::get('master.New end date'))!!}
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
                                            {!! Form::number( 'extension_period_amount',$lease->lease_amount, array("id"=>"extension_period_amount","type"=>'number','v-model'=>'form.extension_period_amount','placeholder'=>'0.00',"class"=>"dealform form-control currency", )) !!}
                                            {!!Form::label('extension_period_amount', Lang::get('master.Fixed asset lease amount'))!!}
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="md-form ">
                                            {!! Form::number( 'extension_service_cost',$lease->lease_service_cost, array("id"=>"extension_service_cost","type"=>'number','v-model'=>'form.extension_service_cost','placeholder'=>'0.00',"class"=>"dealform form-control currency", )) !!}
                                            {!!Form::label('extension_service_cost', Lang::get('master.Services included in lease'))!!}
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="md-form ">
                                            {!! Form::number( 'extension_total_cost',null, array("id"=>"extension_total_cost",'v-model'=>'form.extension_total_cost',"type"=>'number','placeholder'=>'0.00',"class"=>"dealform form-control currency", )) !!}
                                            {!!Form::label('extension_total_cost', Lang::get('master.Total lease payment'))!!}
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
                                            {!! Form::number('lease_extension_rate',$lease->lease_rate, array("id"=>"lease_extension_rate",'v-model'=>'form.lease_extension_rate','placeholder'=>'0.00',"class"=>"dealform form-control currency", )) !!}
                                            {!!Form::label('lease_extension_rate', Lang::get('master.Interest rate'))!!}
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12" v-if="this.modalHeading==='Decrease in scope'">
                                        <div class="md-form ">
                                            {!! Form::number('decrease_in_scope_rate',null, array("id"=>"decrease_in_scope_rate",'v-model'=>'form.decrease_in_scope_rate','placeholder'=>'0.00',"class"=>"dealform form-control currency")) !!}
                                            {!!Form::label('decrease_in_scope_rate', Lang::get('master.Decrease in scope')."(%)")!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="lease_ui_block ">
                            <h1 class="text-decoration-underline-with-margin-zero">{{trans('master.Additions To Liability')}}</h1>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 mt-1">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="md-form ">
                                            {!! Form::number('extension_exercise_price',$lease->exercise_price, array("id"=>"extension_exercise_price",'v-model'=>'form.extension_exercise_price','placeholder'=>'0.00',"class"=>"dealform form-control currency", )) !!}
                                            {!!Form::label('extension_exercise_price',  Lang::get('master.Exercise price of a purchase option')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="md-form ">
                                            {!! Form::number('extension_residual_value_guarantee',$lease->residual_value_guarantee, array("id"=>"extension_residual_value_guarantee",'v-model'=>'form.extension_residual_value_guarantee','placeholder'=>'0.00',"class"=>"dealform form-control currency", )) !!}
                                            {!!Form::label('extension_residual_value_guarantee',  Lang::get('master.Residual value guarantee'))!!}
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="md-form ">
                                            {!! Form::number('extension_penalties_for_terminating',$lease->penalties_for_terminating, array("id"=>"extension_penalties_for_terminating",'v-model'=>'form.extension_penalties_for_terminating','placeholder'=>'0.00',"class"=>"dealform form-control currency", )) !!}
                                            {!!Form::label('extension_penalties_for_terminating', Lang::get('master.Penalties for terminating the lease')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="lease_ui_block ">
                            <h1 class="text-decoration-underline-with-margin-zero">{{trans('master.Price increase')}}</h1>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 mt-1">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="md-form ">
                                            {!!Form::select('price_increase_interval',[3=>3,4=>4,6=>6,12=>12,24=>24,36=>36, 48 => 48, 60 => 60, 120=>120],null, array("id"=>"price_increase_interval",
                                           "class"=>"mdb-select   md-form vue_select_fixer",'v-model'=>'form.price_increase_interval'))!!}
                                            {!!Form::label('price_increase_interval', Lang::get('master.Price increase interval (months)'))!!}
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="md-form ">
                                            {!!Form::number('negotiate_price_increase_amount',null, array("id"=>"negotiate_price_increase_amount", 'placeholder'=>'0.00', "class"=>"form-control currency",'v-model'=>'form.negotiate_price_increase_amount'))!!}
                                            {!!Form::label('negotiate_price_increase_amount', Lang::get('master.Negotiated price increase amount'))!!}
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
                                            {!!Form::input('text','date_of_first_price_increase',$lease->effective_date, array("id"=>"date_of_first_price_increase",
                                     "class"=>"form-control datepickerm date",'v-model'=>'form.date_of_first_price_increase',"placeholder" => Lang::get('master.yyyy-mm-dd')))!!}
                                            {!!Form::label('date_of_first_price_increase', Lang::get('master.Date of last payment with original value'))!!}
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="md-form ">
                                            {!!Form::number('negotiate_price_increase_percent',null, array('v-model'=>'form.negotiate_price_increase_percent',"id"=>"negotiate_price_increase_percent",'placeholder'=>'0.00', "class"=>"form-control currency"))!!}
                                            {!!Form::label('negotiate_price_increase_percent', Lang::get('master.Negotiated price increase %'))!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Accordion wrapper-->
                        <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

                            <!-- Accordion card -->
                            <div class="card card-box-shadow borderRemoval">

                                <!-- Card header -->
                                <div class="card-header primary-background " role="tab" id="headingOne1">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx"
                                       href="#collapseOne1" aria-expanded="false"
                                       aria-controls="collapseOne1">
                                        <h6 class="mb-0 text-left text-black">
                                            {{trans('master.Change in single payment')}}<i
                                                    class="fas fa-angle-down rotate-icon"></i>
                                        </h6>
                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapseOne1" class="collapse" role="tabpanel" aria-labelledby="headingOne1"
                                     data-parent="#accordionEx">
                                    <div class="card-body">
                                        <div class="form-row mb-4">
                                            <div class="col-md-4 col-sm-12">
                                                <h6 class="mb-0 text-left text-black accordion_inner_title_font_size">{{trans('master.Payment month')}}</h6>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <h6 class="mb-0 text-left text-black accordion_inner_title_font_size">{{trans('master.New fixed asset lease amount')}}</h6>


                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <h6 class="mb-0 text-left text-black accordion_inner_title_font_size">{{trans('master.New services included in lease')}}</h6>


                                            </div>
                                            @php
                                                $payment_month_string='form.payment_month';
                                                $payment_value_string='form.payment_value';
                                                $payment_service_cost_string='form.payment_service_cost';

                                            @endphp
                                            @for($i=1;$i<13;$i++)

                                                <div class="col-md-4 col-sm-12">
                                                    <div class="md-form ">
                                                        {!! Form::input('text', "payment_month[$i]",null, array
                                                        ("id"=>"payment_month_".$i,
                                                   "class"=>"form-control datepickerm date lease-change-date-inputs",'v-model'=>'form.payment_month'.$i,"placeholder" => trans('master.yyyy-mm-dd')))!!}
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-12">
                                                    <div class="md-form ">
                                                        {!! Form::input('text', "payment_value[$i]",null, array("id"=>"payment_value_".$i,
                                                         "class"=>"dealform form-control currency","placeholder" => '0.0','v-model'=>'form.payment_value'.$i)) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-12">
                                                    <div class="md-form ">
                                                        {!! Form::input('text', "payment_service_cost[$i]",null, array("id"=>"payment_service_cost_".$i,
                                                 "class"=>"dealform form-control currency","placeholder" => '0.0','v-model'=>'form.payment_service_cost'.$i)) !!}
                                                    </div>
                                                </div>


                                            @endfor
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- Accordion wrapper -->
                    </div>
                    <div class="modal-footer">
                        <button @click="closeModal()" type="button" class="btn btn-secondary waves-effect waves-light"
                                data-dismiss="modal">Close
                        </button>
                        <button type="submit" value="Save" type="button"
                                class="btn btn-primary waves-effect waves-light">Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<div class="row mt-2">
    <table class="table  table-responsive  table-condensed">
        <thead>
        <tr>
            <th>@lang('master.Date of change')</th>
            <th>@lang('master.Effective start date')</th>
            <th>@lang('master.New end date')</th>
            <th>@lang('master.Fixed asset lease amount')</th>
            <th>@lang('master.Services included in lease')</th>
            <th>@lang('master.Total lease payment')</th>
            <th>@lang('master.Interest rate')</th>
            <th>@lang('master.Decrease in scope')(%)</th>
            <th>@lang('master.Lease end payments')</th>
            <th>@lang('master.Change type')</th>
            <th>@lang('master.User')</th>
            <th>@lang('master.Date')</th>
            <th>@lang('master.Action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($leaseExtensions as $leaseExtension)
            <tr>
                <td>{{$leaseExtension->date_of_change}}</td>
                <td>{{$leaseExtension->extension_start_date}}</td>
                <td>{{$leaseExtension->extension_end_date}}</td>
                <td>{{ mYFormat($leaseExtension->extension_period_amount) }}</td>
                <td>{{ mYFormat($leaseExtension->extension_service_cost) }}</td>
                <td>{{ mYFormat($leaseExtension->extension_total_cost) }}</td>
                <td>{{ mYFormat($leaseExtension->lease_extension_rate) }}</td>
                <td>{{ mYFormat($leaseExtension->decrease_in_scope_rate) }}</td>
                <td>{{ mYFormat($leaseExtension->extension_exercise_price +$leaseExtension->extension_residual_value_guarantee +
            $leaseExtension->extension_penalties_for_terminating  ) }}</td>
                <td>{{ $leaseExtension->lease_extension_type }}</td>
                <td>{{ optional($leaseExtension->user)->name }}</td>
                <td>{{ $leaseExtension->created_at->toDateString() }}</td>
                <td>
                    @if($loop->last)
                        @if($buttonShow['delete_ext'])
                            <a href="{{route('lease-extension.delete',$leaseExtension->id)}}" onclick="return confirm('Are you ' +
                                'sure to delete this lease change !! ')">@lang('master.Delete')</a>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>



@push('form-js')
    <style>
        .form_type {
            width: 100%;
            text-align: center;
            padding: 20px 10px;
            border: 1px dotted;
        }

        .form_type:hover {
            background: #1999E3;
            border: 1px solid;
            color: white;
            cursor: pointer;
            -webkit-transition: .3s;
            transition: .3s;
        }

        .display-block {
            display: block !important;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .dropdown-content {
            max-height: 40.625rem !important;
        }
    </style>
    <script>
        new Vue({
            el: '#lease_changes_vue',
            data: {
                showModal: false,
                lease_extension_type: null,
                lease_extension: 0,
                selected_radio: null,
                form: {
                    date_of_change: null,
                    extension_start_date: null,
                    extension_exercise_price: null,
                    extension_residual_value_guarantee: null,
                    extension_penalties_for_terminating: null,
                    extension_end_date: null,
                    extension_period_amount: null,
                    extension_service_cost: null,
                    extension_total_cost: null,
                    lease_extension_rate: null,
                    decrease_in_scope_rate: null,
                    price_increase_interval: null,
                    negotiate_price_increase_amount: null,
                    date_of_first_price_increase: null,
                    negotiate_price_increase_percent: null,
                    payment_month1: null,
                    payment_month2: null,
                    payment_month3: null,
                    payment_month4: null,
                    payment_month5: null,
                    payment_value1: null,
                    payment_value2: null,
                    payment_value3: null,
                    payment_value4: null,
                    payment_value5: null,
                    payment_service_cost1: null,
                    payment_service_cost2: null,
                    payment_service_cost3: null,
                    payment_service_cost4: null,
                    payment_service_cost5: null,

                },
                lease: null,
                today: null,
                modalHeading: null,
                loading: false,
                contentLoaded: true,
            },
            methods: {
                modalPopUp: function (text, radio_id) {
                    this.showModal = true;
                    this.modalHeading = text;
                    this.lease_extension_type = text;
                    this.selected_radio = radio_id;
                    //check box and radio check
                    document.getElementById(radio_id).checked = true;
                    document.getElementById("lease_extension").checked = true;
                    this.lease_extension = 1;
                    this.prefillForm();
                },
                closeModal() {
                    this.showModal = false;
                    this.form = {
                        date_of_change: null,
                        extension_start_date: null,
                        extension_exercise_price: null,
                        extension_residual_value_guarantee: null,
                        extension_penalties_for_terminating: null,
                        extension_end_date: null,
                        extension_period_amount: null,
                        extension_service_cost: null,
                        extension_total_cost: null,
                        lease_extension_rate: null,
                        decrease_in_scope_rate: null,
                        price_increase_interval: null,
                        negotiate_price_increase_amount: null,
                        date_of_first_price_increase: null,
                        negotiate_price_increase_percent: null,
                        payment_month1: null,
                        payment_month2: null,
                        payment_month3: null,
                        payment_month4: null,
                        payment_month5: null,
                        payment_value1: null,
                        payment_value2: null,
                        payment_value3: null,
                        payment_value4: null,
                        payment_value5: null,
                        payment_service_cost1: null,
                        payment_service_cost2: null,
                        payment_service_cost3: null,
                        payment_service_cost4: null,
                        payment_service_cost5: null,
                    };
                    this.lease_extension_type = null;
                    this.lease_extension = 0;
                    //unset checkbox and radio
                    document.getElementById(this.selected_radio).checked = false;
                    document.getElementById("lease_extension").checked = false;
                    //unset radio
                    this.selected_radio = null;

                },
                prefillForm() {
                    this.form.date_of_change = this.today;
                    this.form.extension_start_date = this.today;
                    this.form.extension_end_date = this.lease.maturity_date;
                    this.form.extension_period_amount = this.lease.lease_amount;
                    this.form.extension_service_cost = this.lease.lease_service_cost;
                    this.form.extension_total_cost = parseFloat(Number(this.form.extension_period_amount) + Number(this.form.extension_service_cost)).toFixed(2)

                    this.form.lease_extension_rate = this.lease.lease_rate;
                    this.form.extension_exercise_price = this.lease.exercise_price;
                    this.form.extension_residual_value_guarantee = this.lease.residual_value_guarantee;

                    this.form.extension_penalties_for_terminating = this.lease.penalties_for_terminating;
                    this.form.date_of_first_price_increase = this.lease.effective_date;

                },
                calculateExtensionTotalCost() {
                    this.form.extension_total_cost = parseFloat(Number(this.form.extension_period_amount) + Number(this.form.extension_service_cost)).toFixed(2);
                }
            },
            created() {
                this.lease = window.lease;
                this.today = window.today;
            },
            watch: {
                'form.extension_total_cost': function (oldValue, newValue) {
                    this.calculateExtensionTotalCost();
                },
                'form.extension_period_amount': function (oldValue, newValue) {
                    this.calculateExtensionTotalCost();
                },
                'form.extension_service_cost': function (oldValue, newValue) {
                    this.calculateExtensionTotalCost();
                },


            },
            async mounted() {
                this.prefillForm();
                let self = this;
                $('#extension_start_date').pickadate({
                    format: 'yyyy-mm-dd',
                    onSet: function (context) {
                        self.form.extension_start_date = this.get('select', 'yyyy-mm-dd');
                    }
                });
                $('#date_of_change').pickadate({
                    format: 'yyyy-mm-dd',
                    onSet: function (context) {
                        self.form.date_of_change = this.get('select', 'yyyy-mm-dd');
                    }
                });
                $('#extension_end_date').pickadate({
                    format: 'yyyy-mm-dd',
                    onSet: function (context) {
                        self.form.extension_end_date = this.get('select', 'yyyy-mm-dd');
                    }
                });
                //
                $('#payment_month_1').pickadate({
                    format: 'yyyy-mm-dd',
                    onSet: function (context) {
                        self.form.payment_month1 = this.get('select', 'yyyy-mm-dd');
                    }
                });
                $('#payment_month_2').pickadate({
                    format: 'yyyy-mm-dd',
                    onSet: function (context) {
                        self.form.payment_month2 = this.get('select', 'yyyy-mm-dd');
                    }
                });
                $('#payment_month_3').pickadate({
                    format: 'yyyy-mm-dd',
                    onSet: function (context) {
                        self.form.payment_month3 = this.get('select', 'yyyy-mm-dd');
                    }
                });
                $('#payment_month_4').pickadate({
                    format: 'yyyy-mm-dd',
                    onSet: function (context) {
                        self.form.payment_month4 = this.get('select', 'yyyy-mm-dd');
                    }
                });
                $('#payment_month_5').pickadate({
                    format: 'yyyy-mm-dd',
                    onSet: function (context) {
                        self.form.payment_month5 = this.get('select', 'yyyy-mm-dd');
                    }
                });
                $('.mdb-select').materialSelect();

            }
        });
    </script>
    @push('form-js')
        <style>
            ::-webkit-scrollbar {
                width: 10px;
            }

            /* Track */
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            /* Handle */
            ::-webkit-scrollbar-thumb {
                background: #888;
            }

            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
        </style>
    @endpush
@endpush

@push('header-scripts-area')
    <style>
        .lease-change-date-inputs{
            top:0rem !important
        }
    </style>
@endpush