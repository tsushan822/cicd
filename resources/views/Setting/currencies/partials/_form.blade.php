<div class="pb-4 ">
    <div class=" px-1 cardSimiliarShadow bg-white">
        <section class="dark-grey-text px-2 ">
            <div class="headingandbuttons pb-2 px-2 pt-2 borderFormImportant boxShadowRemoval">
                <div class="d-flex justify-content-between">
                    <div class=" d-flex align-items-center">
                        <div class="pageTitleAndinfo  w-100 text-left">
                            @if(isset($currency))Currency {!!$currency->id!!}@else New
                            Currency @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center zen_tab">

                    </div>
                    <div class="d-flex align-items-center" id="datatable-buttons">
                        <div>
                            <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light" href="{!! route('currencies.index') !!}">
                                <i class="fas fa-arrow-left"></i> @lang('master.Back')
                            </a>

                            <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light" type="submit" value="Save"
                                        id="register_submit"><i
                                            class="fas fa-save"></i> @lang('master.Save')
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
                                    {!!Form::input('text','iso_4217_code',null,array("id"=>"iso_4217_code", "readonly", "class"=>"form-control custom-gray-bg","placeholder"=>trans('master.Code')) )!!}
                                    {!!Form::label('iso_4217_code', trans('master.Code'))!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="md-form ">
                                    {!!Form::input('text','iso_number',null, array("id"=>"iso_number","readonly","class"=>"form-control custom-gray-bg","placeholder"=>trans('master.Numeric code')))!!}
                                    {!!Form::label('iso_number', trans('master.Numeric code'))!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="md-form ">
                                    {!!Form::input('text','iso_3166_code',null,array("id"=>"iso_4217_code","readonly", "class"=>"form-control custom-gray-bg","placeholder"=>trans('master.ISO 3166 Code')))!!}
                                    {!!Form::label('iso_3166_code', trans('ISO 3166 Code'))!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="md-form ">
                                    {!!Form::input('text','currency_name',null,array("id"=>"iso_4217_code","readonly", "class"=>"form-control custom-gray-bg","placeholder"=>trans('master.Currency name')))!!}
                                    {!!Form::label('currency_name', trans('master.Currency name'))!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="switch mt-4 d-flex">
                                    <label>
                                        {!! Form::hidden('active_status', 0) !!}
                                        {!!Form::checkbox('active_status',1, null, ['id'=>'active_status', 'type'=>'checkbox'])!!}
                                        <span class="lever "></span> {!!Form::label('active_status', trans('master.Active'))!!}
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@push('header-scripts-area')
    <style>
       .custom-gray-bg{
           background: #DCDCE0 !important;
           position: relative;
           top: 0.4rem;
       }
    </style>
@endpush

