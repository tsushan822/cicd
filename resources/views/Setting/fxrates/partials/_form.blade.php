<div class="pb-4 ">
    <div class=" px-1 cardSimiliarShadow bg-white">
        <section class="dark-grey-text px-2 ">
            <div class="headingandbuttons pb-2 px-2 pt-2 borderFormImportant boxShadowRemoval">
                <div class="d-flex justify-content-between">
                    <div class=" d-flex align-items-center">
                        <div class="pageTitleAndinfo  w-100 text-left">
                            @lang('master.FX Rate details')
                        </div>
                    </div>
                    <div class="d-flex align-items-center zen_tab">

                    </div>
                    <div class="d-flex align-items-center" id="datatable-buttons">
                        <div>
                            <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light"
                               href="{!! route('fxrates.index') !!}">
                                <i class="fas fa-arrow-left"></i> @lang('master.Back')
                            </a>
                            @if($addOrEditText == 'Edit')
                                @can('create_fxrate')
                                    <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light"
                                       href="{!! route('fxrates.copy', $fxRate->id) !!}">
                                        <i class="fas fa-copy"></i> @lang('master.Copy')
                                    </a>
                                @endcan
                                @can('delete_fxrate')
                                    <a class="btn btn-sm  btn-primary-variant-alert  px-2 waves-effect waves-light"
                                       href="{!! route('fxrates.show', $fxRate->id) !!}">
                                        <i class="fas fa-trash"></i> @lang('master.Delete')
                                    </a>
                                @endcan
                                <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"
                                        type="submit" value="Save"
                                        id="register_submit"><i
                                            class="fas fa-save"></i> @lang('master.Save')
                                </button>
                            @else
                                @can('create_fxrate')
                                    <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"
                                            type="submit" value="Save"
                                            id="register_submit"><i
                                                class="fas fa-save"></i> @lang('master.Add new')
                                    </button>
                                @endcan
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class=" borderRemoval">
                <div class="lease_ui_block">
                    <div class="row row-set-todefault px-2 pt-2 pb-2">

                        <div class="col-md-12 pl-0 col-sm-12 ">
                            <div class="col-md-4">
                                {!!Form::select('ccy_base_id',$currencies,null,array("id"=>"ccy_base_id","class"=>"mdb-select   md-form ","placeholder" => "Currency"))!!}
                                {!!Form::label('ccy_base_id', trans('master.Currency base').'<span class="text-danger">*</span>',[], false)!!}
                            </div>
                            <div class="col-md-4">
                                {!!Form::select('ccy_cross_id',$currencies,null,array("id"=>"ccy_cross_id","class"=>"mdb-select   md-form ","placeholder" => "Currency"))!!}
                                {!!Form::label('ccy_cross_id',trans('master.Currency cross').'<span class="text-danger">*</span>',[], false)!!}
                            </div>
                            <div class="col-md-4">
                                <div class="md-form ">
                                    {!!Form::input('text','rate_bid',null, array("id"=>"rate_bid", "class"=>"dealform form-control decimal", "placeholder" => "0.00"))!!}
                                    {!!Form::label('rate_bid', trans('master.Rate').'<span class="text-danger">*</span>',[], false)!!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form  ">
                                    {!!Form::input('text','date',null, array("id"=>"date", "class"=>"datepicker form-control date","placeholder" => "yyyy-mm-dd"))!!}
                                    {!!Form::label('date', trans('master.Date').'<span class="text-danger">*</span>',[], false)!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>









