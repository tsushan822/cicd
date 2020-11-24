<div class="pb-4 ">
    <div class=" px-1 cardSimiliarShadow bg-white">
        <section class="dark-grey-text px-2 ">
            <div class="headingandbuttons pb-2 px-2 pt-2 borderFormImportant boxShadowRemoval">
                <div class="d-flex justify-content-between">
                    <div class=" d-flex align-items-center">
                        <div class="pageTitleAndinfo  w-100 text-left">
                            @if(isset($leasetype))

                                @lang('master.Lease type') {!!$leasetype->id!!}
                            <br/>
                                @lang('master.Created by') {!! $leasetype->createdByUser->name ?? ''!!}
                                on {!! Carbon\Carbon::parse($leasetype->created_at)->format('jS \o\f F Y')!!}
                                @if(isset($leasetype->updated_user_id))
                                    @lang('master.and last updated by') {!! $leasetype->updatedByUser->name ?? ''!!}
                                    @lang('master.on') {!! Carbon\Carbon::parse($leasetype->updated_at)->format('jS \o\f F Y')!!}
                                @endif
                            @else
                                @lang('master.New Lease Type')
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center zen_tab">

                    </div>
                    <div class="d-flex align-items-center" id="datatable-buttons">
                        <div>
                            <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light" href="{!! route('lease-types.index') !!}">
                                <i class="fas fa-arrow-left"></i> @lang('master.Back')
                            </a>
                            @if($addOrEditText == 'Edit')
                                @can('delete_lease')
                                    <a class="btn btn-sm  btn-primary-variant-alert  px-2 waves-effect waves-light"
                                       href="{!! route('lease-types.show', $leasetype->id) !!}">
                                        <i class="fas fa-trash"></i> @lang('master.Delete')
                                    </a>
                                @endcan
                            @endif

                            <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light" type="submit" value="Save"
                                    id="register_submit"><i
                                        class="fas fa-save"></i>
                                @lang('master.Save')
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <div class=" borderRemoval">
                <div class="lease_ui_block">
                    <div class="row row-set-todefault px-2 pt-2 pb-2">

                        <div class="col-md-12 pl-0 col-sm-12 ">
                            <div class="col-md-4">
                                <div class="md-form ">
                                    {!! Form::text('type', null, ['id'=>'type', 'class' => 'form-control',"placeholder"=>Lang::get('master.Type')]) !!}
                                    {!!Form::label('type','Type<span class="text-danger">*</span>',[],false)!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                {!!Form::select('interest_calculation_method',['Simple' => trans('master.Simple'),'Compound' => trans('master.Compound'), 'Simple actual days' => trans('master.Simple actual days')],null, ["class"=>"mdb-select md-form  "])!!}
                                {!! Form::label('interest_calculation_method', trans('master.Interest calculation method'))!!}
                            </div>

                            <div class="col-md-4">
                                {!!Form::select('payment_type',['In arrears' => trans('master.In arrears'), 'Advance' => trans('master.Advance')],null, ["class"=>"mdb-select md-form  "])!!}
                                {!! Form::label('payment_type', trans('master.Payment type'))!!}
                            </div>
                            <div class="col-md-4">
                                <div class="md-form ">

                                    {!!Form::text('description', null, ['id'=>'description', 'class' => 'form-control',"placeholder"=>Lang::get('master.Description')])!!}
                                    {!!Form::label('description', trans('master.Description'))!!}

                                </div>
                            </div>
                            <div class="col-md-4">
                                {!!Form::select('lease_type_item',$leaseItemIcons,null, array("class"=>"mdb-select   md-form ", "id"=> "lease_type_item","placeholder"=>Lang::get('master.Select (Optional)') ))!!}
                                {!! Form::label('lease_type_item', Lang::get('master.Lease type item')) !!}
                            </div>

                            <div class="col-md-4">

                                {!!Form::select('business_day_convention_id',$businessDayConventions,null, array("class"=>"mdb-select   md-form ", "id"=> "business_day_convention_id" ))!!}
                                {!!Form::label('business_day_convention_id', Lang::get('master.Business day convention'))!!}

                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    {!!Form::input('text','lease_valuation_rate',null, array("class"=>"dealform form-control currency", "placeholder"=>"0.00" ))!!}
                                    {!! Form::label('lease_valuation_rate', trans('master.Lease valuation rate')) !!}

                                </div>
                            </div>

                            <div class="col-md-4">

                                {!!Form::select('extra_payment_in_fees',[0 => trans('master.No'),1 => trans('master.Yes')],null, array("class"=>"mdb-select   md-form ", "id"=> "extra_payment_in_fees" ))!!}
                                {!! Form::label('extra_payment_in_fees', trans('master.Include service into price increase'))!!}

                            </div>

                            <div class="col-md-4">

                                {!!Form::select('exclude_first_payment',[0 => trans('master.No'),1 => trans('master.Yes')],null, array("class"=>"mdb-select   md-form ", "id"=> "exclude_first_payment" ))!!}
                                {!! Form::label('exclude_first_payment', trans('master.Exclude first payment'))!!}
                                <small>{{trans('master.Exclude first payment from discount calculation if agreement is paid in advance and 12 times a year')}}</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>