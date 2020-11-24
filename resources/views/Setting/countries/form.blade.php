<div class="pb-4 ">
    <div class=" px-1 cardSimiliarShadow bg-white">
        <section class="dark-grey-text px-2 ">
            <div class="headingandbuttons pb-2 px-2 pt-2 borderFormImportant boxShadowRemoval">
                <div class="d-flex justify-content-between">
                    <div class=" d-flex align-items-center">
                        <div class="pageTitleAndinfo  w-100 text-left">
                             {{trans('master.Country')}}
                        </div>
                    </div>
                    <div class="d-flex align-items-center zen_tab">

                    </div>
                    <div class="d-flex align-items-center" id="datatable-buttons">
                        <div>
                            <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light"
                               href="{!! route('portfolios.index') !!}">
                                <i class="fas fa-arrow-left"></i> @lang('master.Back')
                            </a>

                            @if(isset($portfolio))
                                @can('create_portfolio')
                                    <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light"
                                       href="{!! route('portfolios.copy', $portfolio->id) !!}">
                                        <i class="fas fa-clone"></i> @lang('master.Copy')
                                    </a>
                                @endcan
                            @endif


                            @can('edit_portfolio')
                                <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"
                                        type="submit" value="Save" id="register_submit"><i
                                            class="fas fa-save"></i> @lang('master.Save')
                                </button>
                            @endcan
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
                                    {!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                                    {!! Form::label('name', 'Name') !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="md-form ">
                                    {!!Form::text('iso_3166_code', null, ['id'=>'iso_3166_code', 'class' =>
                                    'form-control','disabled','placeholder' => trans('master.ISO 3166 Code')])!!}
                                    {!!Form::label('iso_3166_code', trans('master.ISO 3166 Code'))!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                {!!Form::select('currency_id', $currencies,null,array('class'=>'mdb-select   md-form ','placeholder' => trans('master.Currency')))!!}
                                {!!Form::label('currency_id', trans('master.Currency'))!!}
                            </div>
                            <div class="col-md-4 text-left">


                                {!! Form::label('is_EEA', 'Is Eea', ['class' => ' pl-0  control-label active']) !!}
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="materialInline1" name="is_EEA">
                                    <label class="form-check-label"
                                           for="materialInline1">{{Lang::get('master.Yes')}}</label>
                                </div>

                                <!-- Group of material radios - option 2 -->
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="materialInline2" name="is_EEA">
                                    <label class="form-check-label"
                                           for="materialInline2">{{Lang::get('master.No')}}</label>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


