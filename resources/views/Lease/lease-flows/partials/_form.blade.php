<div class="bg-white cardSimiliarShadow px-2">
    <div class=" borderForm  px-0 py-2  boxShadowRemoval">
        <div class="d-flex justify-content-between">
            <div class=" d-flex align-items-center">
                <div class="pageTitleAndinfo  w-100 text-left">
                    @if(isset($copy))
                        @includeIf('sub-views.createdByUserText',['deal' => $leaseFlow,'copy' => $copy, 'type'=> trans('master
                        .LeaseFlow')])
                    @elseif(isset($leaseFlow))
                        @includeIf('sub-views.createdByUserText',['deal' => $leaseFlow, 'type'=> trans('master.LeaseFlow')])
                    @else
                        @includeIf('sub-views.createdByUserText',['type'=> trans('master.LeaseFlow')])
                    @endif
                </div>
            </div>
            <div class="d-flex align-items-center" id="datatable-buttons">
                <div>
                    <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light"
                       href="{!! route('leases.edit', $lease->id) !!}">
                        <i class="fas fa-arrow-left"></i> @lang('master.Back')
                    </a>
                    @can('edit_lease_flow')
                        <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"
                                type="submit" value="Save" id="register_submit"><i
                                    class="fa fa-cogs"></i>
                            @lang('master.Save')
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class=" borderRemoval">
        <div class="lease_ui_block">
            <div class="row pb-0">

                <div class="col-md-12  col-sm-12 mt-2">

                    <div class="col-md-4  col-sm-12 ">
                        <div class="md-form ">
                            {!!Form::input('text','start_date',null, array("id"=>"start_date", "class"=>"datepicker form-control date",
                                                              "placeholder" => trans("master.yyyy-mm-dd"),"disabled" => true))!!}
                            {!!Form::label('start_date', trans('master.Calculation start date'))!!}
                        </div>

                    </div>
                    <div class="col-md-4  col-sm-12 ">
                        <div class="md-form ">
                            {!!Form::input('text','description',null, array("id"=>"text", "class"=>"form-control"))!!}
                            {!!Form::label('text', trans('master.Description'))!!}
                        </div>
                    </div>
                    <div class="col-md-4  col-sm-12 ">
                        <div class="md-form ">
                            {!!Form::input('text','fixed_payment',$leaseFlow->total_lease, array("id"=>"fixed_payment", "class"=>"dealform form-control currency",'placeholder'=>'0.00',"disabled" => $disableFixAmount))!!}
                            {!!Form::label('fixed_payment', trans('master.Fixed payment amount'))!!}
                        </div>
                    </div>
                    <div class="col-md-4  col-sm-12 ">
                        <div class="md-form ">

                            {!!Form::input('text','payment_date',null, array("id"=>"payment_date", "class"=>"datepicker form-control date",
                           "placeholder" => trans("master.yyyy-mm-dd")))!!}
                            {!!Form::label('payment_date',
                           trans('master.Payment date'))!!}
                        </div>
                    </div>
                    <div class="col-md-4  col-sm-12 ">
                        <div class="md-form ">

                            {!!Form::input('text','end_date',null, array("id"=>"end_date", "class"=>"datepicker form-control date",
                            "placeholder" => trans("master.yyyy-mm-dd"), "disabled" => true))!!}
                            {!!Form::label('end_date', trans('master.Calculation end date'))!!}

                        </div>
                    </div>
                    <div class="col-md-4  col-sm-12 ">
                        <div class="md-form ">
                            {!!Form::input('text','fees',null, array("id"=>"text", 'placeholder'=>'0.00', "class"=>"form-control currency"))!!}
                            {!!Form::label('fees', trans('master.Fee'))!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
</div>


