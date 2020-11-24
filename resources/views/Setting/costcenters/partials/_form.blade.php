<div class="pb-4 ">

    <div class=" px-1 cardSimiliarShadow bg-white">

        <section class="dark-grey-text px-2 ">

            <div class="headingandbuttons pb-2 px-2 pt-2 borderFormImportant boxShadowRemoval">
                <div class="d-flex justify-content-between">
                    <div class=" d-flex align-items-center">
                        <div class="pageTitleAndinfo  w-100 text-left">
                            @if(isset($copy))
                                @includeIf('sub-views.createdByUserText',['deal' => $costCenter,'copy' => $copy, 'type'=> trans('master
                                .Cost center')])
                            @elseif(isset($costCenter))
                                @includeIf('sub-views.createdByUserText',['deal' => $costCenter, 'type'=> trans('master.Cost center')])
                            @else
                                @includeIf('sub-views.createdByUserText',['type'=> trans('master.Cost center')])
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center zen_tab">

                    </div>
                    <div class="d-flex align-items-center" id="datatable-buttons">
                        <div>
                            <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light"
                               href="{!! route('costcenters.index') !!}">
                                <i class="fas fa-arrow-left"></i> @lang('master.Back')
                            </a>
                            @if($addOrEditText == 'Edit')
                                @can('create_costcenter')

                                    <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light"
                                       href="{!! route('costcenters.copy', $costCenter->id) !!}">

                                        <i class="fas fa-clone"></i> @lang('master.Copy')

                                    </a>

                                @endcan

                                @can('delete_costcenter')

                                    <a class="btn btn-sm  btn-primary-variant-alert  px-2 waves-effect waves-light"
                                       href="{!! route('costcenters.show', $costCenter->id) !!}">

                                        <i class="fas fa-trash"></i> @lang('master.Delete')

                                    </a>

                                @endcan
                                @can('edit_costcenter')

                                    <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"
                                            type="submit" value="Save" id="register_submit"><i
                                                class="fas fa-save"></i>
                                        @lang('master.Save')
                                    </button>

                                @endcan
                            @else
                                @can('create_costcenter')

                                    <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"
                                            type="submit" value="Save" id="register_submit"><i
                                                class="fas fa-save"></i>
                                        @lang('master.Add new')
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
                                <div class="md-form ">
                                    {!!Form::input('text','short_name',null, array("class"=>"form-control",'placeholder'=>trans('master.Cost center short name') ))!!}
                                    {!!Form::label('short_name', trans('master.Short name').'<span class="text-danger">*</span>',[],false)!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="md-form ">
                                    {!!Form::input('text','long_name',null, array("class"=>"form-control",'placeholder'=>trans('master.Long name') ))!!}
                                    {!!Form::label('long_name', trans('Long name').'<span class="text-danger">*</span>',[],
                                    false)!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </div>
</div>