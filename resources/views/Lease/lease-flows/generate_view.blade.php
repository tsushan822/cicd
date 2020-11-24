@extends('layouts.master')
@section('css')
@stop
@section('content')
    {!! Form::open(array('route' => 'lease-flows.generate.store')) !!}
    <div class="pb-4 ">

        <div class=" px-1 cardSimiliarShadow bg-white">

            <section class="dark-grey-text px-2 ">

                <div class="headingandbuttons pb-2 px-2 pt-2 borderFormImportant boxShadowRemoval">
                    <div class="d-flex justify-content-between">
                        <div class=" d-flex align-items-center">
                            <div class="pageTitleAndinfo  w-100 text-left">
                                <h2 class="section-heading  d-flex justify-content-center justify-content-md-start"></h2>
                            </div>
                        </div>
                        <div class="d-flex align-items-center zen_tab">

                        </div>
                        <div class="d-flex align-items-center" id="datatable-buttons">
                            <div>
                                <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light"
                                   href="{!! route('lease-flows.generate',$lease->id) !!}">
                                    <i class="fas fa-arrow-left"></i>
                                    @lang('master.Back')
                                </a>
                                @can('edit_lease')
                                    <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"
                                            type="submit" value="Save" id="register_submit"><i
                                                class="fas  fa-save"></i>
                                        @lang('master.Save')
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" borderRemoval">
                    <div class="card-deck">
                        <div class="card ml-0 mr-0 ml-1 pl-1 mr-1 px-0 py-0 borderRemoval boxShadowRemoval">
                            <div class="card-body pt-1">
                                <table
                                        class="table  dt-responsive dataTable no-footer dtr-inline collapsed"
                                        cellspacing="0" width="100%" role="grid"
                                        aria-describedby="datatable-responsive_info" style="width: 100%;">
                                    <thead>
                                    <tr class="custom_tr">
                                        <th>{{trans('master.Calculation start date')}}</th>
                                        <th>{{trans('master.Calculation end date')}}</th>
                                        <th>{{trans('master.Payment date')}}</th>
                                        <th>{{trans('master.Lease Payment')}}</th>
                                        <th>{{trans('master.Service cost')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $calculationStartDate = $startDate; ?>
                                    @foreach($paymentDates as $paymentDate)
                                        <tr class="custom_tr">
                                            <td>{{ $paymentDate['start_date'] }}</td>
                                            <td>{!! $paymentDate['end_date'] !!}</td>
                                            <td>{{ $paymentDate['payment_date'] }}</td>
                                            <td>{{ mYFormat($paymentDate['fixed_amount']) }}</td>
                                            <td>{{ mYFormat($paymentDate['fees']) }}</td>
                                        </tr>
                                        <?php $calculationStartDate = $paymentDate; ?>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
    <input type='hidden' name='payments_time'
           value="<?php echo htmlentities(serialize($paymentDates)); ?>"/>

    <input type='hidden' name='lease' value="{{$lease -> id}}"/>
    <input type='hidden' name='calc_start_date' value="{{$startDate}}"/>
    <input type='hidden' name='lease_payment' value="{{$leasePayment}}"/>
    <input type='hidden' name='fees' value="{{$fees}}"/>
    {!! Form::close() !!}
@endsection

@section('javascript')
    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="/js/vendor/jquery-ui.min.js"></script>
    <script src="{{ mix('/js/custom/deals.js') }}"></script>
    <style>
        .custom_tr th,.custom_tr td {
            padding-left: 0 !important;
            text-align: left !important;
        }
    </style>

@stop