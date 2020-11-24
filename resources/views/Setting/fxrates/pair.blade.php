@extends('layouts.master')
@section('css')
@stop
@section('content')

    {!!Form::open(['id'=>'fxrate-update-form','method'=>'POST', 'route'=>['fxrates.pair.post'],
'data-parsley-validate class'=>'form-horizontal'])!!}
<div class="pb-4 pt-4">
    <div class="card card-cascade narrower mt-4">

        <!--Card image-->
        <div
                class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
            <a href="" class="white-text mx-3"> {{ trans('master.Add currency pair') }}</a>

            <div>

                <a class="btn btn-outline-white  btn-sm px-2" href="{!! route('fxrates.index') !!}">
                    <i class="fas fa-arrow-left"></i> @lang('master.Back')
                </a>


                    <button class="btn btn-outline-white  btn-sm px-2" type="submit" value="Save"
                            id="register_submit"><i
                                class="fas fa-save"></i> @lang('master.Save')
                    </button>

            </div>


        </div>


        <div class="px-4">

            <div class="table-wrapper">

                <div class="px-4">


                    <div class="row">
                        <div class="col-md-12">
                               <p class="note note-primary">
                                   {{ trans('master.Add currency pair') }}
                               </p>
                         </div>
                        <div class="col-md-4">
                            {!!Form::select('base_currency', $currencies ,null,['class'=>'mdb-select   md-form md-outline','placeholder' => trans
              ('master.Choose base currency')])!!}
                            {!!Form::label('base_currency', Lang::get('master.List of base currency'))!!}

                         </div>
                        <div class="col-md-4">
                            {!!Form::select('converting_currency', $currencies ,null,['class'=>'mdb-select   md-form md-outline','placeholder' =>
                                       trans('master.Choose converting currency')])!!}
                            {!!Form::label('converting_currency', Lang::get('master.List of converting currency'))!!}

                         </div>

                        <div class="col-md-4">
                            {!!Form::select('referencing_currency', $currencies ,null,['class'=>'mdb-select   md-form md-outline','placeholder' =>
                                        trans('master.Choose referencing currency')])!!}
                            {!!Form::label('referencing_currency', Lang::get('master.Choose referencing currency'))!!}

                         </div>
                    </div>



                    <div class="table-wrapper">

                        <div class="my-3 borderForm"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <p class="note note-primary">
                                    {{ trans('master.List of currency pairs') }}
                                </p>
                            </div>
                        </div>


                        <div class="card-deck mb-4">

                            <div class="card boxShadowRemoval">
                                <div class="card-body">
                                    <table class="table table-responsive ">
                                        <thead>
                                        <tr>
                                            <th>{{ trans('master.Id') }}</th>
                                            <th>{{ trans('master.Base currency') }}</th>
                                            <th>{{ trans('master.Converting currency') }}</th>
                                            <th>{{ trans('master.Referencing currency') }}</th>
                                            <th>{{ trans('master.Delete') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($currencyPairs as $currencyPair)
                                            <tr>
                                                <td>{{$currencyPair->id}}</td>
                                                <td>
                                                    <img src="/vendor/famfamfam/png/{!! $currencyPair->baseCurrency->iso_3166_code !!}.png">
                                                    {{$currencyPair->baseCurrency->iso_4217_code}}
                                                </td>
                                                <td>
                                                    <img src="/vendor/famfamfam/png/{!! $currencyPair->convertingCurrency->iso_3166_code !!}.png"> {{$currencyPair->convertingCurrency->iso_4217_code}}
                                                </td>
                                                <td>
                                                    <img src="/vendor/famfamfam/png/{!! $currencyPair->referencingCurrency->iso_3166_code !!}.png"> {{$currencyPair->referencingCurrency->iso_4217_code}}
                                                </td>
                                                <td><a href="{{route('fxrates.pair.delete',$currencyPair->id)}}"
                                                       onclick="return confirm('Are you sure to delete?')">@lang('master.Delete')</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


            </div>

        </div>
    </div>
</div>
    {!!Form::close()!!}
    @stop









