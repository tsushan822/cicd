<div class="d-none">
    @javascript('view', $view)
</div>

<div class="pb-4 " id="report_form_generation">

    <div class=" px-1 cardSimiliarShadow bg-white">

        <section class="dark-grey-text px-2 ">

            <div class="d-none text-left mt-2" id="errorArea" v-if="_.isEmpty(!form.errors.errors)">
                <div v-for="singleError in form.errors.errors"
                     class="chip danger-color lighten-2 white-text waves-effect waves-effect">
                    <span v-text="singleError[0]"></span>
                    <i class="close fas fa-times"></i>
                </div>
            </div>

            <div class="headingandbuttons pb-2 px-2 pt-2 borderFormImportant boxShadowRemoval">
                <div class="d-flex justify-content-between">
                    <div class=" d-flex align-items-center">
                        <div class="pageTitleAndinfo  w-100 text-left">
                            <h6 class="pl-1"><strong>{!!$title!!}</strong></h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center zen_tab">

                    </div>
                    <div class="d-flex align-items-center" id="datatable-buttons">
                        <div>
                            @switch($model)
                                @case('lease')
                                @if(!isset($showButtonOff))
                                    <a @click="showSubmit()" type="submit" value="submit" name="submitButton"
                                       class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"><i
                                                class="fas fa-eye"></i> @lang('master.Show')</a>
                                @endif
                                @break
                                @default
                                <a @click="showSubmit()"
                                   class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"><i
                                            class="fas fa-eye"></i> @lang('master.Show')</a>
                            @endswitch
                            @if(app('reportLibraryAvailability'))
                                <a @click="saveSubmit()"
                                   class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"><i
                                            class="fas fa-save"></i> @lang('master.Save')</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class=" borderRemoval">
                <div class="lease_ui_block">
                    <div class="row row-set-todefault px-2 pt-2 pb-2">

                        <div class="col-md-12 pl-0 col-sm-12 ">
                            <div class="card-body px-lg-5 pt-0">
                                <div class="row mt-5 mb-5 d-none" id="loaderarea" :class="{'d-block': form.busy | loading}" >
                                    <div class="col-md-12 mb-3">
                                        <div class="d-flex justify-content-center">
                                            <!--Big blue-->
                                            <div class="preloader-wrapper small active">
                                                <div class="spinner-layer spinner-blue-only">
                                                    <div class="circle-clipper left">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="gap-patch">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="circle-clipper right">
                                                        <div class="circle"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100 mt-4">
                                        <div class="pageTitleAndinfo  w-100 text-center">
                                            <h6 class="pl-1">
                                                <strong v-text="loader_text"></strong>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div id="all_area" class="d-none" :class="{'d-block': !form.busy && !loading   }">
                                    <div class="row">
                                        <div class="col-md-12 pl-0 mt-1 text-left">
                                            <h6>{{trans('master.Required')}}</h6>
                                        </div>
                                        @switch($StartEndOrReportDate)
                                            @case('StartEnd')
                                            <div class="col-md-6 pl-0">
                                                <div class="md-form  ">
                                                    {!!Form::input('text','start_date',$view['start_date'], array("id"=>"start_date","autocomplete"=>"off", "class"=>"datepicker start_date_picker form-control date  ","v-model"=>"form.start_date","placeholder" => "yyyy-mm-dd"))!!}
                                                    {!!Form::label('start_date', Lang::get('master.Start date'))!!}
                                                    <has-error :form="form" field="start_date"></has-error>
                                                </div>
                                            </div>

                                            <div class="col-md-6 pl-0">
                                                <div class="md-form  ">
                                                    {!!Form::input('text','end_date',$view['end_date'], array("id"=>"end_date","autocomplete"=>"off", "class"=>"datepicker  end_date_picker form-control date ","v-model"=>"form.end_date","placeholder" => "yyyy-mm-dd"))!!}
                                                    {!!Form::label('end_date', Lang::get('master.End date'))!!}
                                                    <has-error :form="form" field="end_date"></has-error>
                                                </div>
                                            </div>

                                            @break

                                            @case('StartWithMonth')

                                            <div class="col-md-6 pl-0">
                                                <div class="md-form  ">
                                                    {!!Form::input('text','end_date',$view['end_date'], array("id"=>"end_date","autocomplete"=>"off", "class"=>"datepicker end_date_picker form-control date ","v-model"=>"form.end_date","placeholder" => "yyyy-mm-dd"))!!}

                                                    {!!Form::label('end_date', Lang::get('master.Report start date'))!!}

                                                    <has-error :form="form" field="end_date"></has-error>

                                                </div>
                                            </div>


                                            <div class="col-md-6 pl-0">

                                                {!!Form::select('number_of_month',[1 => 1,2 => 2,3 => 3],$view['number_of_month'], array("id"=>"number_of_month","placeholder"=>Lang::get('master.Select number of months'),"autocomplete"=>"off","v-model"=>"form.number_of_month", "class"=>"mdb-select   md-form "))!!}
                                                {!!Form::label('number_of_month', Lang::get('master.Number of months'))!!}


                                            </div>




                                            @break

                                            @default

                                            <div class="col-md-6 pl-0">
                                                <div class="md-form  ">
                                                    {!!Form::input('text','end_date',$view['end_date'], array("id"=>"end_date","v-model"=>"form.end_date","autocomplete"=>"off", "class"=>"datepicker end_date_picker form-control date ","placeholder" => "yyyy-mm-dd"))!!}

                                                    {!!Form::label('end_date', Lang::get('master.Report date'))!!}

                                                    <has-error :form="form" field="end_date"></has-error>

                                                </div>
                                            </div>


                                        @endswitch
                                        @if(isset($currency))
                                            <div class="col-md-6 pl-0">
                                                {!!Form::select('currency_id', $currencies,$view['currency_id'],['id' => 'currency_id','class'=>'mdb-select    md-form ', "v-model"=>"form.currency_id", 'placeholder' => trans('master.Select')])!!}
                                                {!!Form::label('currency_id', Lang::get('master.Currency'))!!}
                                            </div>
                                        @endif
                                        <div class="col-md-12 pl-0 mt-1 text-left">
                                            <h6>{{trans('master.Optionals')}}</h6>
                                        </div>
                                        <div class="col-md-6 pl-0">
                                            {!!Form::select('entity_id[]', $entities,$view['entity_id'],['id' => 'entity_id','class'=>'mdb-select hide-second-element-of-dropdown    md-form ','multiple' => 'multiple', "v-model"=>"form.entity_id", 'placeholder' => trans('master.Select (Optional)')])!!}
                                            {!!Form::label('entity_id', Lang::get('master.Entity'))!!}
                                        </div>
                                        <div class="col-md-6 pl-0">
                                            {!!Form::select('counterparty_id[]',$counterparties,$view['counterparty_id'], array("id"=>"counterparty_id", 'multiple' => 'multiple',"class"=>"mdb-select  hide-second-element-of-dropdown  md-form ", "v-model"=>"form.counterparty_id", 'placeholder' => trans('master.Select (Optional)')))!!}
                                            {!!Form::label('counterparty_id', Lang::get('master.Counterparty'))!!}
                                        </div>

                                        <div class="col-md-6 pl-0">
                                            {!!Form::select('portfolio_id[]', $portfolios,$view['portfolio_id'],['id' => 'portfolio_id','multiple' => 'multiple','class'=>'mdb-select  hide-second-element-of-dropdown  md-form ',  "v-model"=>"form.portfolio_id", 'placeholder' => trans('master.Select (Optional)')])!!}
                                            {!!Form::label('portfolio_id', Lang::get('master.Portfolio'))!!}
                                        </div>
                                        <div class="col-md-6 pl-0">
                                            {!!Form::select('cost_center_id[]',$costCenters,$view['cost_center_id'], array("id"=>"cost_center_id",'multiple' => 'multiple', "class"=>"mdb-select  hide-second-element-of-dropdown  md-form ", "v-model"=>"form.cost_center_id", 'placeholder' => trans('master.Select (Optional)')))!!}
                                            {!!Form::label('cost_center_id', Lang::get('master.Cost center'))!!}
                                        </div>

                                        <div class="col-md-6 pl-0">
                                            @switch($model)
                                                @case('mmdeal')

                                                {!!Form::select('instrument_id[]',$instruments,$view['instrument_id'], array("id"=>"instrument_id", 'multiple' => 'multiple',"class"=>"mdb-select  hide-second-element-of-dropdown  md-form ", "v-model"=>"form.instrument_id", 'placeholder' => trans('master.Select (Optional)')))!!}
                                                {!!Form::label('instrument_id', Lang::get('master.Instrument'))!!}


                                                @break
                                                @case('accrued')

                                                {!!Form::select('instrument_id[]',$instruments,$view['instrument_id'], array("id"=>"instrument_id", 'multiple' => 'multiple',"class"=>"mdb-select  hide-second-element-of-dropdown  md-form ", "v-model"=>"form.instrument_id",'placeholder' => trans('master.Select (Optional)')))!!}

                                                {!!Form::label('instrument_id', Lang::get('master.Instrument'))!!}

                                                @break
                                                @case('lease')

                                                {!!Form::select('lease_type_id[]', $leaseTypes,$view['lease_type_id'],['id' => 'lease_type_id','class'=>'mdb-select  hide-second-element-of-dropdown  md-form ', "v-model"=>"form.lease_type_id", 'multiple' => 'multiple','placeholder' => trans('master.Select (Optional)')])!!}

                                                {!!Form::label('lease_type_id', Lang::get('master.Lease type'))!!}

                                                @break
                                                @case('guarantee')

                                                {!!Form::select('guarantee_type_id[]', $guaranteeTypes,$view['guarantee_type_id'],['id' => 'guarantee_type_id','class'=>'mdb-select  hide-second-element-of-dropdown  md-form ',"v-model"=>"form.guarantee_type_id",'multiple' => 'multiple','placeholder' => trans('master.Select (Optional)')])!!}

                                                {!!Form::label('guarantee_type_id', Lang::get('master.Guarantee type'))!!}

                                                @break
                                                @case('fxdeal')

                                                {!!Form::select('fx_type_id[]', $fxTypes,$view['fx_type_id'],['id' => 'fx_type_id','class'=>'mdb-select hide-second-element-of-dropdown   md-form ', "v-model"=>"form.fx_type_id", 'multiple' => 'multiple','placeholder' => trans('master.Select (Optional)')])!!}
                                                {!!Form::label('fx_type_id', Lang::get('master.Instrument'))!!}


                                                @break

                                            @endswitch
                                        </div>
                                        @if(!isset($currency))
                                            <div class="col-md-6 pl-0">
                                                {!!Form::select('currency_id', $currencies,$view['currency_id'],['id' => 'currency_id','class'=>'mdb-select    md-form ', "v-model"=>"form.currency_id", 'placeholder' => trans('master.Select (Optional)')])!!}
                                                {!!Form::label('currency_id', Lang::get('master.Currency'))!!}
                                            </div>
                                        @endif


                                        @switch($model)
                                            @case('mmdeal')
                                            <div class="col-md-6 pl-0">
                                                <div class="md-form  ">
                                                    {!!Form::input('text','mm_deal_id',null, array("id"=>"mm_deal_id", "class"=>"form-control number","v-model"=>"form.mm_deal_id","placeholder" => Lang::get('master.Enter Loan Id (Optional)')))!!}
                                                    {!!Form::label('mm_deal_id', Lang::get('master.Loan Id'))!!}
                                                </div>
                                            </div>

                                            @break

                                            @case('lease')
                                            @if(!isset($noID))
                                                <div class="col-md-6 pl-0">
                                                    <div class="md-form  ">
                                                        {!!Form::input('text','lease_id',null, array("id"=>"lease_id","v-model"=>"form.lease_id", "class"=>"form-control number","placeholder" => Lang::get('master.Enter lease Id (Optional)')))!!}
                                                        {!!Form::label('lease_id', Lang::get('master.Lease Id'))!!}
                                                        <has-error :form="form" field="lease_id"></has-error>
                                                    </div>
                                                </div>

                                            @endif
                                            @break
                                            @case('guarantee')
                                            <div class="col-md-6 pl-0">
                                                <div class="md-form  ">
                                                    {!!Form::input('text','guarantee_id',null, array("id"=>"guarantee_id", "v-model"=>"form.guarantee_id","class"=>"form-control number","placeholder" => Lang::get('master.Enter guarantee Id (Optional)')))!!}

                                                    {!!Form::label('guarantee_id', Lang::get('master.Guarantee Id'))!!}

                                                    <has-error :form="form" field="guarantee_id"></has-error>


                                                </div>
                                            </div>
                                            @break
                                            @case('fxdeal')
                                            <div class="col-md-6 pl-0">
                                                <div class="md-form  ">
                                                    {!!Form::input('text','fx_deal_id',null, array("id"=>"fx_deal_id", "class"=>"form-control number","v-model"=>"form.fx_deal_id","placeholder" => Lang::get('master.Enter FX Id (Optional)')))!!}
                                                    {!!Form::label('fx_deal_id', Lang::get('master.FX deal Id'))!!}
                                                    <has-error :form="form" field="fx_deal_id"></has-error>

                                                </div>
                                            </div>


                                            @break
                                            @case('accrued')
                                            <div class="col-md-6 pl-0">
                                                {!!Form::select('report_grouping', ['Portfolio', 'Instrument'] ,isset($filter)?$filter:null,['id' => 'report_grouping',"v-model"=>"form.report_grouping",'class'=>'mdb-select    md-form '])!!}
                                                {!!Form::label('report_grouping', Lang::get('master.Report grouping'))!!}
                                                <has-error :form="form" field="report_grouping"></has-error>

                                            </div>

                                            @break
                                        @endswitch

                                        <div class="col-md-6 pl-0">
                                            <div class="md-form  ">
                                                {!!Form::input('text','custom_report_name',$view['custom_report_name'], array("id"=>"custom_report_name","v-model"=>"form.custom_report_name", "class"=>"form-control number","placeholder" => Lang::get('master.Enter report name (Mandatory while saving the report)')))!!}
                                                {!!Form::label('custom_report_name', Lang::get('master.Report name'))!!}
                                                <has-error :form="form" field="custom_report_name"></has-error>
                                            </div>
                                        </div>
                                        {!!Form::hidden('report_library_id', $view['id'],array("v-model"=>"form.report_library_id","name"=>"report_library_id","class"=>"d-none"))!!}


                                    </div>
                                    <button type="submit" value="submit" name="submitButton" ref="showButtonSubmit"
                                            class="d-none"> @lang('master.Show')</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </div>
</div>

@section('javascript')
    <script src="{{ mix('/tenant/app.js') }}"></script>
    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="{{ mix('/js/vendor/jquery-ui.min.js') }}"></script>
    <script>
        new Vue({
            el: '#report_form_generation',
            data() {
                return {
                    // Create a new form instance
                    submitUrl: '',
                    loading: false,
                    tableData: false,
                    loader_text:'',
                    form: new Form({
                        entity_id: null,
                        counterparty_id: null,
                        portfolio_id: null,
                        cost_center_id: null,
                        instrument_id: null,
                        lease_type_id: null,
                        guarantee_type_id: null,
                        fx_type_id: null,
                        currency_id: null,
                        start_date: null,
                        number_of_month: null,
                        end_date: null,
                        mm_deal_id: null,
                        lease_id: null,
                        guarantee_id: null,
                        fx_deal_id: null,
                        report_grouping: null,
                        custom_report_name: null,
                        submitButton: '',
                    })
                }
            },
            methods: {
                saveReport() {
                    this.loader_text ='Saving the report...'
                    let self=this;
                    this.form.post(document.getElementById('vueForm').action)
                        .then(({data}) => {
                            self.loader_text ='Report has been created!'
                            self.loading = true;
                            window.location.href = data.redirectRoute;
                        })
                    // Submit the form via a POST request
                },
                submitReport() {
                    this.loader_text ='Generating the report...';
                    let self=this;
                    this.form.post(document.getElementById('vueForm').action)
                        .then(({data}) => {
                            self.loader_text ='Generating the report...'
                            self.loading = true;
                            this.$refs.showButtonSubmit.click()
                        })
                    // Submit the form via a POST request
                },
                saveSubmit() {
                    this.form.submitButton = 'save';
                    this.saveReport();
                },
                showSubmit() {
                    this.form.submitButton = 'submit';
                    this.submitReport();
                },
                setModel(view) {
                    if (view.hasOwnProperty('id')) {
                        view.report_library_id = view.id;
                        Object.assign(this.form, view);
                        var multiSelectArray = ['entity_id', 'counterparty_id', 'portfolio_id', 'cost_center_id', 'instrument_id', 'lease_type_id', 'guarantee_type_id', 'fx_type_id'];
                        multiSelectArray.forEach(element => {
                            if (this.form[element] === null) {
                                this.form[element] = [];
                            }
                        })
                    }
                },
            },
            created() {
                this.setModel(window.view);
            },
            async mounted() {
                let self = this;
                $('.end_date_picker').pickadate({
                    format: 'yyyy-mm-dd',
                    onSet: function (context) {
                        self.form.end_date = this.get('select', 'yyyy-mm-dd');
                    }
                });
                $('.start_date_picker').pickadate({
                    format: 'yyyy-mm-dd',
                    onSet: function (context) {
                        self.form.start_date = this.get('select', 'yyyy-mm-dd');
                    }
                });
            }
        })
        $(document).ready(function () {
            $("#errorArea").removeClass("d-none")
        });
    </script>
    <style>
        .invalid-feedback {
            display: block !important;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 80%;
            color: #dc3545;
            text-align: left;
        }

        .modal-dialog {
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            max-width: none !important;

        }

        .modal-content {
            height: auto !important;
            min-height: 100% !important;
            border-radius: 0 !important;
            background-color: #ececec !important
        }

        .select-wrapper + label {
            position: absolute !important;
            left: 9px !important;
            /* font-size: 1rem; */
            color: #757575 !important;
            cursor: text !important;
            transition: color 0.2s ease-out, -webkit-transform 0.2s ease-out !important;
            transition: transform 0.2s ease-out, color 0.2s ease-out !important;
            transition: transform 0.2s ease-out, color 0.2s ease-out, -webkit-transform 0.2s ease-out !important;
            -webkit-transform: translateY(12px) !important;
            transform: translateY(12px) !important;
            -webkit-transform-origin: 0% 100% !important;
            transform-origin: 0% 100% !important;
            display: inline-block !important;
            margin-bottom: 0.5rem !important;
            top: .5em !important;
            z-index: 2 !important;
            top: 0 !important;
            font-weight: 300 !important;
        }
    </style>
@endsection

@push('header-css')
    <style>
        .hide-second-element-of-dropdown > .multiple-select-dropdown >li:nth-child(2){
            display:none !important
        }
        .form-control[readonly] {
            top: 0rem !important;
        }
    </style>
@endpush

