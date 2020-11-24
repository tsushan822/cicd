<div class="pb-4 ">

    <div class=" px-1 cardSimiliarShadow bg-white">

        <section class="dark-grey-text px-2 ">
            <div class="headingandbuttons  px-0 py-2 borderRemoval boxShadowRemoval">
                <div class="d-flex justify-content-between">
                    <div class=" d-flex align-items-center">
                        <div class="pageTitleAndinfo  w-100 text-left">
                            @if(isset($copy))
                                @includeIf('sub-views.createdByUserText',['deal' => $counterparty,'copy' => $copy, 'type'=> Lang::get('master.Company')])
                            @elseif(isset($counterparty))
                                @includeIf('sub-views.createdByUserText',['deal' => $counterparty, 'type'=> Lang::get('master.Company')])
                            @else
                                @includeIf('sub-views.createdByUserText',['type'=> Lang::get('master.Company')])
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center zen_tab">

                    </div>
                    <div class="d-flex align-items-center" id="datatable-buttons">
                        <div>
                            <a class="btn btn-sm btn-primary-variant-one  px-2 waves-effect waves-light" href="{!! route('counterparties.index') !!}">
                                <i class="fas   fa-arrow-left"></i>
                                <span>@lang('master.Back')</span>
                            </a>

                            @if($addOrEditText == 'Edit')

                                @can('create_counterparty')

                                    <a class="btn btn-sm btn-primary-variant-one  px-2 waves-effect waves-light" href="{!! route('counterparties.copy', $counterparty->id) !!}">
                                        <i class="fas  fa-clone "></i>
                                        <span>@lang('master.Copy')</span>
                                    </a>
                                @endcan


                                @if(!$counterparty->is_parent_company)
                                    @can('delete_counterparty')
                                        <a class="btn btn-sm btn-primary-variant-alert  px-2 waves-effect waves-light"
                                           href="{!! route('counterparties.show', $counterparty->id) !!}">
                                            <i class="far  fa-minus-square "></i>
                                            <span>@lang('master.Delete')</span>
                                        </a>
                                    @endcan

                                @endif

                                @can('edit_counterparty')

                                    <button class="btn btn-sm btn-primary-variant-main  px-2 waves-effect waves-light" type="submit" value="Save"
                                            id="register_submit"><i
                                                class="fas fa-save"></i>
                                        <span>@lang('master.Save')</span>
                                    </button>

                                @endcan
                            @endif

                            @if($addOrEditText == 'Add New')
                                @can('create_counterparty')
                                    <button class="btn btn-sm btn-primary-variant-main  px-2 waves-effect waves-light" type="submit" value="Save"
                                            id="register_submit"><i
                                                class="fas  fa-save"></i>
                                        <span>@lang('master.Add new')</span>
                                    </button>
                                @endcan
                            @endif

                        </div>
                    </div>
                </div>
            </div>


            <ul class="nav ml-2 mr-2 nav-tabs" role="tablist">

                <li class="nav-item">
                    <a class="nav-link borderRadiusRemoval active" data-toggle="tab" href="#essential" role="tab">
                        @lang('master.ESSENTIALS')
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link borderRadiusRemoval " data-toggle="tab" href="#additional" role="tab">
                        @lang('master.ADDITIONAL')
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link borderRadiusRemoval text-uppercase " data-toggle="tab" href="#ifrs" role="tab">
                        @lang('master.Interest')</a>
                </li>

                @if(isset($counterparty))
                    <li class="nav-item">
                        <a class="nav-link borderRadiusRemoval" data-toggle="tab" id="audittrail-tab" href="#audit_trail"
                           role="tab">
                            @lang('master.AUDIT TRAIL')</a>
                    </li>
                @endif

            </ul>

            <div class="classic-tabs mx-2">

                <div class="tab-content card boxShadowRemoval pl-2 borderRemoval pt-1">
                    <!--Panel 1-->
                    <div class="tab-pane  fade in show active" id="essential" role="tabpanel">

                        <div class="card z-depth-0 border border-light rounded-0 unsetCardBorder">

                            <!--Card content-->
                            <div class="card-body pl-1 pt-1   ">

                                <div class="row row-eq-height">

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="md-form ">
                                                    {!!Form::input('text','short_name',null, array("class"=>"form-control",'placeholder'=>Lang::get('master.Short name') ))!!}
                                                    {!!Form::label('short_name',  Lang::get('master.Short name'))!!}
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="md-form ">
                                                    {!!Form::input('text','long_name',null, array("class"=>"form-control",'placeholder'=>Lang::get('master.Long name')  ))!!}
                                                    {!!Form::label('long_name', Lang::get('master.Long name'))!!}
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                {!!Form::select('currency_id',$currencies ,null,array("class"=>"mdb-select   md-form ","placeholder" =>
                                                trans("master.Currency")))!!}
                                                {!!Form::label('currencies', Lang::get('master.Base Currency'))!!}
                                            </div>
                                            <div class="col-md-12 searchable-country-select-area">
                                                <select id="country_id"  name="country_id" class="mdb-select md-form" searchable="Search here..">
                                                    <option value="" disabled selected>Choose your country</option>
                                                    @foreach($countries as $key=>$country)
                                                        @if(isset($counterparty))
                                                            @if($counterparty->country_id == $key)
                                                                <option value="{!! $key !!}"
                                                                        selected>{!! $country !!}</option>
                                                            @else
                                                                <option value="{!! $key !!}">{!! $country !!}</option>
                                                            @endif
                                                        @else
                                                            <option value="{!! $key !!}">{!! $country !!}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                {!!Form::label('country_id', trans('master.Country'))!!}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column h-50 justify-content-around align-items-start">

                                            <div class="switch mt-3 d-flex">
                                                <label>
                                                    {!! Form::hidden('is_entity', 0) !!}
                                                    {!!Form::checkbox('is_entity',1, null, ['id'=>'is_entity','type' => 'checkbox'])!!}
                                                    <span class="lever "></span> {!!Form::label('is_entity', Lang::get('master.Entity'))!!}

                                                </label>
                                            </div>
                                            <div class="switch mt-3 d-flex">
                                                <label>

                                                    {!! Form::hidden('is_counterparty', 0) !!}
                                                    {!!Form::checkbox('is_counterparty',1, null, ['id'=>'is_counterparty', 'type'=>'checkbox'])!!}
                                                    <span class="lever "></span> {!!Form::label('is_counterparty', Lang::get('master.Counterparty'))!!}


                                                </label>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="tab-pane  fade in show  " id="additional" role="tabpanel">
                        <div class="card-deck mb-4">
                            <div class="card borderRemoval boxShadowRemoval">
                                <div class="card-body pl-1 pt-1  ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="md-form ">
                                                {!!Form::input('text','postal_address1',null, array("class"=>"form-control",'placeholder'=> 'max 128 characters', 'maxlength'=>'128' ))!!}
                                                {!!Form::label('postal_address1', trans('master.Postal address line 1'))!!}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane  fade in show  " id="ifrs" role="tabpanel">
                        <div class="card-deck mb-4">
                            <div class="card borderRemoval boxShadowRemoval">
                                <div class="card-body pl-1 pt-1  ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="md-form ">
                                                {!! Form::input('text', 'lease_rate',null, array("id"=>"lease_rate","class"=>"dealform form-control currencyNonNegative","placeholder" => "12.00")) !!}
                                                {!!Form::label('lease_rate', trans('master.Interest rate'))!!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card borderRemoval boxShadowRemoval">
                                <div class="card-body pl-1 pt-1  ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="switch mt-4 d-flex">
                                                <label>
                                                    {!! Form::hidden('ifrs_accounting', 0) !!}
                                                    {!! Form::checkbox('ifrs_accounting',1, null,  ['id'=>'ifrs_accounting', 'type'=>'checkbox']) !!}
                                                    <span class="lever "></span> {!! Form::label('ifrs_accounting', trans('master.Calculate balance sheet values')) !!}

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane  fade in show " id="audit_trail" role="tabpanel">
                        @if(isset($counterparty))
                            {!! Form::hidden('model_id', request()->segment(2),['id' => 'model_id']) !!}
                            {!! Form::hidden('model', 'Counterparty',['id' => 'model']) !!}
                            @include('layouts.all.ajax_audit_trail')
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!--Section: Content-->


    </div>
</div>


@push('header-scripts-area')
    <style>
        .searchable-country-select-area{
            position: relative;
            top: 1px;
        }
    </style>

@endpush



