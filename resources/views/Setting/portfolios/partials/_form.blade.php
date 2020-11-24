<div class="pb-4 ">
    <div class=" px-1 cardSimiliarShadow bg-white">
        <section class="dark-grey-text px-2 ">
            <div class="headingandbuttons pb-2 px-2 pt-2 borderFormImportant boxShadowRemoval">
                <div class="d-flex justify-content-between">
                    <div class=" d-flex align-items-center">
                        <div class="pageTitleAndinfo  w-100 text-left">
                            @if(isset($copy))
                                @includeIf('sub-views.createdByUserText',['deal' => $portfolio,'copy' => $copy, 'type'=> trans('master.Portfolio')])
                            @elseif(isset($portfolio))
                                @includeIf('sub-views.createdByUserText',['deal' => $portfolio, 'type'=> trans('master.Portfolio')])
                            @else
                                @includeIf('sub-views.createdByUserText',['type'=> trans('master.Portfolio')])
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center zen_tab">

                    </div>
                    <div class="d-flex align-items-center" id="datatable-buttons">
                        <div>
                            <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light" href="{!! route('portfolios.index') !!}">
                                <i class="fas fa-arrow-left"></i> @lang('master.Back')
                            </a>

                            @if(isset($portfolio))
                                @can('create_portfolio')
                                    <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light" href="{!! route('portfolios.copy', $portfolio->id) !!}">
                                        <i class="fas fa-clone"></i> @lang('master.Copy')
                                    </a>
                                @endcan
                            @endif


                            @can('edit_portfolio')
                                <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light" type="submit" value="Save" id="register_submit"><i
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
                                    {!!Form::input('text','name',null, array("class"=>"form-control",'placeholder' => trans('master.Short name') ))!!}
                                    {!!Form::label('name', trans('master.Name').'<span class="text-danger">*</span>',[], false)!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="md-form ">
                                    {!!Form::input('text','long_name',null, array("class"=>"form-control",'placeholder' => trans('master.Description') ))!!}
                                    {!!Form::label('long_name', trans('master.Description').'<span class="text-danger">*</span>',[], false)!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>








