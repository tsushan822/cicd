

@extends('layouts.master')
@section('content')
    @if ($configsettings->isEmpty())

    @else

<div class="pb-4 pt-4">
    <div class="card card-cascade narrower mt-4">

        <!--Card image-->
        <div
                class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
            <a href="" class="white-text mx-3">System configuration</a>

        </div>


        <div class="px-4">

            <div class="table-wrapper">


                <div class="form-row">
                    <div class="col-md-6">

                        <h6>Forecasting</h6>
                        <hr>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    @if(isset($configsettings[1]))
                                    <div class="md-form md-outline">


                                            {!!Form::model($configsettings[1],['id'=>'configsetting-update-form','method'=>'PATCH',
                                            'route'=>['config-settings.edit', $configsettings[1]->id],'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}


                                            {!!Form::label('value_date', 'Short-term forecasting starting date:')!!}



                                            {!!Form::input('text','value_date',null, array("id"=>"value_date",
                                            "class"=>"datepicker form-control date","placeholder" => "yyyy-mm-dd"))!!}



                                        @endif

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-md mt-3 btn-success" type="submit" value="Save"><i
                                                class="fa fa-save"></i>
                                        Save
                                    </button>
                                    {!!Form::close()!!}
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    @if(isset($configsettings[0]))
                                        <div class="md-form md-outline">


                                            {!!Form::model($configsettings[0],['id'=>'configsetting-update-form','method'=>'PATCH',
                             'route'=>['config-settings.edit', $configsettings[0]->id],'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}


                                            {!!Form::label('value_date', 'Long-term forecasting starting date:')!!}



                                            {!!Form::input('text','value_date',null, array("id"=>"effective_date",
                                            "class"=>"datepicker form-control date","placeholder" => "yyyy-mm-dd"))!!}



                                            @endif

                                        </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-md mt-3 btn-success" type="submit" value="Save"><i
                                                class="fa fa-save"></i>
                                        Save
                                    </button>
                                    {!!Form::close()!!}
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    @if(isset($configsettings[4]))
                                        <div class="md-form md-outline">


                                            {!!Form::model($configsettings[4],['id'=>'configsetting-update-form','method'=>'PATCH',
                             'route'=>['config-settings.edit', $configsettings[4]->id],'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}

                                            {!!Form::label('active', $configsettings[4]->description.':')!!}


                                            {!!Form::input('number','value_int',null, array("id"=>"effective_date",
                                             "class"=>"form-control","placeholder" => "Length of short forecast days"))!!}



                                            @endif

                                        </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-md mt-3 btn-success" type="submit" value="Save"><i
                                                class="fa fa-save"></i>
                                        Save
                                    </button>
                                    {!!Form::close()!!}
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    @if(isset($configsettings[1]))
                                        <div class="md-form md-outline">


                                            {!!Form::model($configsettings[1],['id'=>'configsetting-update-form','method'=>'PATCH',
                                            'route'=>['config-settings.edit', $configsettings[1]->id],'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}


                                            {!!Form::label('value_date', 'Short-term forecasting starting date:')!!}



                                            {!!Form::input('text','value_date',null, array("id"=>"value_date",
                                            "class"=>"datepicker form-control date","placeholder" => "yyyy-mm-dd"))!!}



                                            @endif

                                        </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-md mt-3 btn-success" type="submit" value="Save"><i
                                                class="fa fa-save"></i>
                                        Save
                                    </button>
                                    {!!Form::close()!!}
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    @if(isset($configsettings[2]))
                                        <div class="switch mt-3 d-flex">
                                         <label>
                                             {!!Form::model($configsettings[2],['id'=>'configsetting-update-form','method'=>'PATCH',
                                'route'=>['config-settings.edit', $configsettings[2]->id],'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}

                                             {!!Form::checkbox('active',1, null, ['class' => 'checkbox'])!!}
                                           <span class="lever "></span> {!!Form::label('active', $configsettings[2]->description.':')!!}

                                          </label>
                                           </div>
                                    @endif


                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-md mt-3 btn-success" type="submit" value="Save"><i
                                                class="fa fa-save"></i>
                                        Save
                                    </button>
                                    {!!Form::close()!!}
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <h6 class="">System</h6>
                        <hr>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    @if(isset($configsettings[3]))
                                        <div class="md-form md-outline">


                                            {!!Form::model($configsettings[3],['id'=>'configsetting-update-form','method'=>'PATCH',
                              'route'=>['config-settings.edit', $configsettings[3]->id],'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}

                                            {!!Form::label('value_date', 'FX rate starting period:')!!}



                                            {!!Form::input('text','value_date',null, array("id"=>"FxRateDate", "class"=>"datepicker form-control date","placeholder" => "yyyy-mm-dd"))!!}




                                            @endif

                                        </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-md mt-3 btn-success" type="submit" value="Save"><i
                                                class="fa fa-save"></i>
                                        Save
                                    </button>
                                    {!!Form::close()!!}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>



            </div>

        </div>

    </div>
</div>

@endif
@stop
@section('javascript')

    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="/js/vendor/jquery-ui.min.js"></script>
    <script src="{{ mix('/js/custom/deals.js') }}"></script>

@stop