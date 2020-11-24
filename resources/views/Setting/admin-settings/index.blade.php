@extends('layouts.master')
@section('content')
    @if (!$adminSetting instanceof \App\Zen\Setting\Model\AdminSetting)
    @else
        {!!Form::open(array('route'=> ['admin-settings.create']))!!}

        <div class="pb-4 ">
            <div class=" px-1 cardSimiliarShadow bg-white">
                <!--Section: Content-->
                <section class="dark-grey-text px-2 ">
                    <div class="headingandbuttons  px-0 py-2 borderRemoval boxShadowRemoval">
                        <div class="d-flex justify-content-between">
                            <div class=" d-flex align-items-center">
                                <div class="pageTitleAndinfo ml-2 pl-1  w-100 text-left">
                                    @lang('master.Admin Settings')
                                </div>
                            </div>
                            <div class="d-flex align-items-center zen_tab"></div>
                            <div class="d-flex align-items-center" id="datatable-buttons">
                                <div>

                                    <button class="btn btn-sm btn-primary-variant-main  px-2 waves-effect waves-light"
                                            type="submit" value="save" name="submit"><i
                                                class="fas   fa-save"></i>
                                        <span>@lang('master.Save')</span>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" borderRemoval">
                        <div class="card-deck">
                            <div class="card ml-0 mr-0 ml-1 pl-1 px-0 py-0 borderRemoval boxShadowRemoval">
                                <div class="card-body pt-1">
                                    <div class="row">
                                        @if($dataBondRateImport)
                                            <div class="col-md-6 text-left">
                                                <h2 class="title pl-0"><u>{{trans('master.FxRate source')}}</u></h2>
                                                <select name="databond_source" class="mdb-select md-form">
                                                    <option value="">{{trans('master.Select fx-rate source')}}</option>
                                                    @foreach($dataBondSources as $dataBondSource)
                                                        <option @if($dataBondRateId==$dataBondSource) selected @endif>
                                                            {{ $dataBondSource }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>
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
                                            <h2 class="title pl-0"><u>{{trans('master.Freeze period')}}</u></h2>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="md-form  ">
                                                {!!Form::input('text','freezer_date',$adminSetting->freezer_date, ["id"=>"freezer_date",
                                                'class' => 'datepicker form-control date','placeholder' => 'yyyy-mm-dd'])!!}
                                                {!!Form::label('freezer_date', Lang::get('master.date freeze label'))!!}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            {!!Form::select('date_freezer_active',['0' => trans('master.Not active'),'Full' => trans('master.Full'),'Adjustable' => trans('master.Adjustable')],$adminSetting->date_freezer_active,['id'=>'date_freezer_active','class' => 'mdb-select   md-form '])!!}
                                            {!!Form::label('date_freezer_active', Lang::get('master.Date freezer active'))!!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card ml-0 mr-1 ml-0 pl-0 pr-1 px-0 py-0 borderRemoval boxShadowRemoval">
                                <div class="card-body pt-1">
                                    <div class="row">
                                        <div class="col-md-12 text-left">
                                            <h2 class="title pl-0"><u>{{trans('master.Miscellaneous settings')}}</u>
                                            </h2>
                                        </div>
                                        <div class="col-md-12 mt-2 mb-2 text-left">
                                            <div class="form-check pl-0">
                                                {!! Form::hidden('auth_log', 0) !!}
                                                {!!Form::checkbox('auth_log',1, $adminSetting->auth_log, ['id'=>'auth_log', 'type'=>'checkbox','class'=>'form-check-input'])!!}
                                                {!!Form::label('auth_log', Lang::get('master.Email notify on new device login'), array("class"=>"form-check-label" ))!!}
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2 mb-2 text-left">
                                            <div class="form-check pl-0">
                                                {!! Form::hidden('enable_cost_center_split', 0) !!}
                                                {!!Form::checkbox('enable_cost_center_split',1, $adminSetting->enable_cost_center_split, ['id'=>'enable_cost_center_split', 'type'=>'checkbox', 'class'=>'form-check-input', 'class'=>'form-check-input'])!!}
                                                {!!Form::label('enable_cost_center_split', trans('master.Enable lease cost center split'),array("class"=>"form-check-label" ))!!}
                                            </div>
                                        </div>
                                    </div>
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
                                            <h2 class="title pl-0"><u>{{trans('master.Password rule')}}</u></h2>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="md-form ">
                                                {!!Form::text('min_password_length',$adminSetting->min_password_length, ["id"=>"min_password_length",'class' => 'form-control'])!!}
                                                {!!Form::label('min_password_length', trans('master.Min password length'))!!}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="md-form ">
                                                {!!Form::text('max_password_length',$adminSetting->max_password_length, ["id"=>"max_password_length",'class' => 'form-control'])!!}
                                                {!!Form::label('max_password_length', trans('master.Max password length'))!!}
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2 mb-2 text-left">
                                            <div class="form-check pl-0">
                                                {!! Form::hidden('enable_change_password', 0) !!}
                                                {!!Form::checkbox('enable_change_password',1, $adminSetting->enable_change_password, ['id'=>'enable_change_password','type'=>'checkbox', 'class'=>'form-check-input'])!!}
                                                {!!Form::label('enable_change_password', trans('master.Enable change password'), array("class"=>"form-check-label" ))!!}
                                            </div>

                                        </div>
                                        <div class="col-md-12">
                                            <div class="md-form ">
                                                {!!Form::text('password_change_days',$adminSetting->password_change_days, ["id"=>"password_change_days",'class' => 'form-control'])!!}
                                                {!!Form::label('password_change_days', trans('master.Change password after days'))!!}
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2 mb-2 text-left">
                                            <div class="form-check pl-0">
                                                {!! Form::hidden('enable_failed_login_lock', 0) !!}
                                                {!!Form::checkbox('enable_failed_login_lock',1, $adminSetting->enable_failed_login_lock, ['id'=>'enable_failed_login_lock','type'=>'checkbox', 'class'=>'form-check-input'])!!}
                                                {!!Form::label('enable_failed_login_lock', trans('master.Enable lock after login attempts'), array("class"=>"form-check-label" ))!!}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="md-form ">
                                                {!!Form::text('number_of_unsuccessful_login',$adminSetting->number_of_unsuccessful_login, ["id"=>"number_of_unsuccessful_login",'class' => 'form-control'])!!}
                                                {!!Form::label('number_of_unsuccessful_login', trans('master.Lock after login attempts'))!!}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card ml-0 mr-1 ml-0 pl-0 pr-1 px-0 py-0 borderRemoval boxShadowRemoval">
                                <div class="card-body pt-1">
                                    <div class="row">
                                        <div class="col-md-12 text-left">
                                            <h2 class="title pl-0"><u>{{trans('master.Password character rule')}}</u>
                                            </h2>
                                        </div>
                                        <div class="col-md-12 mt-2 mb-2 text-left">
                                            <div class="form-check pl-0">
                                                {!! Form::hidden('one_capital', 0) !!}
                                                {!!Form::checkbox('one_capital',1, $returnValues['one_capital'], ['id'=>'one_capital',
                                                'type'=>'checkbox','class'=>'form-check-input'])!!}
                                                {!!Form::label('one_capital', trans('master.One capital'),array("class"=>"form-check-label" ))!!}
                                            </div>


                                        </div>
                                        <div class="col-md-12 mt-2 mb-2 text-left">
                                            <div class="form-check pl-0">
                                                {!! Form::hidden('one_small', 0) !!}
                                                {!!Form::checkbox('one_small',1, $returnValues['one_small'], ['id'=>'one_small',
                                                'type'=>'checkbox','class'=>'form-check-input'])!!}
                                                {!!Form::label('one_small', trans('master.One small'), array("class"=>"form-check-label" ))!!}
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-2 mb-2 text-left">
                                            <div class="form-check pl-0">
                                                {!! Form::hidden('one_special', 0) !!}
                                                {!!Form::checkbox('one_special',1, $returnValues['one_special'], ['id'=>'one_special', 'type'=>'checkbox', 'class'=>'form-check-input'])!!}
                                                {!!Form::label('one_special', trans('master.One special character'), array("class"=>"form-check-label" ))!!}

                                            </div>

                                        </div>
                                        <div class="col-md-12 mt-2 mb-2 text-left">
                                            <div class="form-check pl-0">
                                                {!! Form::hidden('one_number', 0) !!}
                                                {!!Form::checkbox('one_number',1, $returnValues['one_number'], ['id'=>'one_number',
                                                'type'=>'checkbox', 'class'=>'form-check-input'])!!}
                                                {!!Form::label('one_number', trans('master.One Number'), array("class"=>"form-check-label" ))!!}
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
        {!!Form::close()!!}

    @endif
@stop
@section('javascript')



@stop





