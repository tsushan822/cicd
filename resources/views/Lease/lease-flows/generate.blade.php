@extends('layouts.master')
@section('css')
@stop
@section('content')
    {!!Form::model($lease,['id'=>'guarantee-update-form' ,'method'=>'POST', 'route'=>'lease-flows.generate.post',
     'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}
    <div class="pb-4 ">

        <div class=" px-1 cardSimiliarShadow bg-white">

            <section class="dark-grey-text px-2 ">

                <div class="headingandbuttons pb-2 px-2 pt-2 borderFormImportant boxShadowRemoval">
                    <div class="d-flex justify-content-between">
                        <div class=" d-flex align-items-center">
                            <div class="pageTitleAndinfo  w-100 text-left">
                                <h2 class="section-heading  d-flex justify-content-center justify-content-md-start">@lang('master.Payment schedule generator')</h2>
                            </div>
                        </div>
                        <div class="d-flex align-items-center zen_tab">

                        </div>
                        <div class="d-flex align-items-center" id="datatable-buttons">
                            <div>
                                <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light" href="{!! route('leases.edit',$lease->id) !!}">
                                    <i class="fas fa-arrow-left"></i> @lang('master.Back')
                                </a>
                                @can('edit_lease')
                                    <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light" type="submit" value="Save" id="register_submit"><i
                                                class="fa fa-cogs"></i>
                                        @lang('master.Generate')
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" borderRemoval">
                    <div class="card-deck">
                        <div class="card ml-0 mr-0 ml-1 pl-1 px-0 py-0 borderRemoval boxShadowRemoval">
                            <div class="card-body pt-1">
                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <h2 class="title pl-0"><u>{{trans('master.Payment details')}}</u></h2>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="md-form ">
                                            {!!Form::input('text','payment_date',$lease->first_payment_date, array("id"=>"payment_date", "class"=>"form-control
                                        datepicker date","placeholder" => "yyyy-mm-dd"))!!}

                                            {!!Form::label('payment_date', 'First end date')!!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="md-form ">
                                            {!!Form::input('text','start_date',$lease->effective_date, array("id"=>"start_date",
                                                                                    "class"=>"form-control datepicker date","placeholder" => "yyyy-mm-dd","disabled" => true))!!}
                                            {!!Form::label('start_date', 'Calculation start date')!!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="md-form ">
                                            {!!Form::input('text','lease_payment_amount',$lease->lease_amount, array("id"=>"lease_payment_amount", 'placeholder'=>'0.00',"step"=>"any",
                                                                                     "class"=>"form-control currency"))!!}
                                            {!!Form::label('lease_payment_amount', 'Fixed Asset Lease amount')!!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="md-form ">
                                            {!!Form::input('text','fees',$lease->lease_service_cost, array("id"=>"fees", "step"=>"any",
                                             "class"=>"form-control currency"))!!}
                                            {!!Form::label('fees', 'Lease Service Cost')!!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="md-form ">
                                            {!!Form::input('text','end_date',$lease->maturity_date, array("id"=>"end_date", "class"=>"form-control
                                           datepicker date","placeholder" => "yyyy-mm-dd"))!!}
                                            {!!Form::label('end_date', 'End date')!!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card ml-0 mr-1 ml-0 pl-0 pr-1 px-0 py-0 borderRemoval boxShadowRemoval">
                            <div class="card-body pt-1">
                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <h2 class="title pl-0"><u>{{trans('master.Price Increase')}}</u></h2>
                                    </div>
                                    <div class="col-md-12">
                                        {!!Form::select('price_increase_interval',[3=>3,  4=>4, 6 => 6,12 => 12, 24 => 24, 36 => 36, 48 => 48, 60 => 60],null, array("id"=>"price_increase_interval",
                                      "class"=>"mdb-select   md-form "))!!}
                                        {!!Form::label('price_increase_interval', 'Price Increase Interval(Months)')!!}
                                    </div>
                                    <div class="col-md-12">
                                        <div class="md-form ">
                                            {!!Form::input('text','date_of_first_price_increase',$lease->effective_date, array("id"=>"date_of_first_price_increase",
                                   "class"=>"form-control datepicker date","placeholder" => "yyyy-mm-dd"))!!}
                                            {!!Form::label('date_of_first_price_increase', 'Date of last payment with original value')!!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="md-form ">
                                            {!!Form::input('text','negotiate_price_increase_amount',null, array("id"=>"negotiate_price_increase_amount",'placeholder'=>'0.00', "class"=>"form-control currency"))!!}
                                            {!!Form::label('negotiate_price_increase_amount', 'Negotiated Price Increase Amount')!!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="md-form ">
                                            {!!Form::input('text','negotiate_price_increase_percent',null, array("id"=>"negotiate_price_increase_percent",'placeholder'=>'0.00', "class"=>"form-control currency"))!!}
                                            {!!Form::label('negotiate_price_increase_percent', 'Negotiated Price Increase Percent')!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </section>
        </div>
    </div>
    <input type='hidden' name='lease' value="{{$lease -> id}}"/>
    {!!Form::close()!!}
@endsection


@section('javascript')
    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="/js/vendor/jquery-ui.min.js"></script>
    <script src="{{ mix('/js/custom/deals.js') }}"></script>
@endsection