@extends('layouts.dashboard')
@section('css')

@stop
@section('content')
    @if(!$environmentIsReady)
        @push('checkEnvironmentReadiness')
            <dashboard-loader></dashboard-loader>
        @endpush
    <div class="spinner_area_holder">
        <div class="d-flex justify-content-center dashboard-custom-spinner-area flex-column align-items-center" style="min-height: 97vh;">
            <div class="w-100">
                <div class="spinner-border dashboard-custom-spinner" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <h5 class="w-100 mt-5 ml-4">Importing demo data.....</h5>

        </div>
    </div>
    @else
    <div class="dashboard_area_holder">
        <div class="animated  zoomIn"></div>
        <section class="">

            <!-- Grid row -->
            <div class="row customRow">
            @if(isset($numberOfEachType['Machinery']))
                <!-- Grid column -->
                    <div class="col-md-2  customColPadding">
                        <!-- Card -->
                        <div class="card card-cascade cascading-admin-card">

                            <!-- Card Data -->
                            <div class="admin-up">
                                <i class="fas fa-tools malachite-background  z-depth-2"></i>
                                <div class="data w-100">
                                    <p class="text-uppercase">{{trans('master.Machinery')}}</p>
                                    <h4 class="font-weight-bold dark-grey-text">{{count($numberOfEachType['Machinery'])}}</h4>
                                </div>
                            </div>

                            {{-- <!-- Card content -->
                             <div class="card-body card-body-cascade">
                                 <div class="progress mb-3">
                                     <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                             </div>--}}

                        </div>
                        <!-- Card -->

                    </div>
                    <!-- Grid column -->
            @endif
            @if(isset($numberOfEachType['Vehicle']))
                <!-- Grid column -->
                    <div class="col-md-2  customColPadding">
                        <div class="card card-cascade cascading-admin-card">

                            <!-- Card Data -->
                            <div class="admin-up">
                                <i class="fas fa-car golden_fizz-background  z-depth-2"></i>
                                <div class="data w-100">
                                    <p class="text-uppercase">{{trans('master.Vehicle')}}</p>
                                    <h4 class="font-weight-bold dark-grey-text">{{count($numberOfEachType['Vehicle'])}}</h4>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Grid column -->
            @endif
            @if(isset($numberOfEachType['IT']))
                <!-- Grid column -->
                    <div class="col-md-2  customColPadding">
                        <div class="card card-cascade cascading-admin-card">

                            <!-- Card Data -->
                            <div class="admin-up">
                                <i class="fas fa-desktop dodger_blue-background   z-depth-2"></i>
                                <div class="data w-100">
                                    <p class="text-uppercase">{{trans('master.IT')}}</p>
                                    <h4 class="font-weight-bold dark-grey-text">{{count($numberOfEachType['IT'])}}</h4>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Grid column -->
            @endif
            @if(isset($numberOfEachType['Building']))
                <!-- Grid column -->
                    <div class="col-md-2  customColPadding">
                        <div class="card card-cascade cascading-admin-card">

                            <!-- Card Data -->
                            <div class="admin-up">
                                <i class=" fas fa-building sunset_orange-background  z-depth-2"></i>
                                <div class="data w-100">
                                    <p class="text-uppercase">{{trans('master.Building')}}</p>
                                    <h4 class="font-weight-bold dark-grey-text">{{count($numberOfEachType['Building'])}}</h4>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- Grid column -->
            @endif
            @if(isset($numberOfEachType['Other']))
                <!-- Grid column -->
                    <div class="col-md-2  customColPadding">

                        <div class="card card-cascade cascading-admin-card">

                            <!-- Card Data -->
                            <div class="admin-up">
                                <i class="fas fa-file-archive jungle_green-background    z-depth-2"></i>
                                <div class="data w-100">
                                    <p class="text-uppercase">{{trans('master.Other')}}</p>
                                    <h4 class="font-weight-bold dark-grey-text">{{count($numberOfEachType['Other'])}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Grid column -->
            @endif
            <!-- Grid column -->
                <div class="col-md-2  customColPadding">
                    <div class="card card-cascade cascading-admin-card">

                        <!-- Card Data -->
                        <div class="admin-up">
                            <i class="fas fa-equals pizazz-background    z-depth-2"></i>

                            <div class="data w-100">
                                <p class="text-uppercase">{{trans('master.Total')}}</p>
                                <h4 class="font-weight-bold dark-grey-text"> {{$numberOfEachType['total']}}</h4>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- Grid column -->

            </div>
            <!-- Grid row -->

        </section>
        <div id="app">



            <!-- Section: Chart -->
            <section>

                <!-- Grid row -->
                <div class="row customRow">
                    <div class="col-md-12 customColPadding">
                        <div class="card h-100" style="">
                            <div class="text-black text-left  d-flex align-items-start  py-2 px-2 rounded ">
                                <div class="text-center w-100">
                                    <h6 class="text-left  card-header paddingLeftPointFour">
                                        <i class="fas  fa-chart-line fa-1x mr-1 "></i>    <strong> {{trans('master.Liabilities')}}</strong>
                                    </h6>
                                    <div class="content_with_action px-3 ">

                                        <template id="stackedlinegraphleases"
                                                  style="position: relative; height: 50vh">

                                            <stackedlinegraphleases url="/api/stackedlinegraphleases"
                                                                    :range="{{$returnValue['default']}}"
                                                                    :rangemonths={{$returnValue['rangeMonths']}} showtitle="{{false}}">
                                            </stackedlinegraphleases>
                                        </template>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="row customRow row-eq-height">


                <div class="col-md-4 customColPadding">
                    <div class="card h-100" style="">
                        <div class="text-black text-left  d-flex align-items-start  py-2 px-2 rounded ">
                            <div class="text-center w-100">
                                <h6 class="text-left  card-header paddingLeftPointFour">
                                    <i class="fas  fa-bell fa-1x mr-1 "></i> <strong> {{trans('master.Maturing leases')}}</strong>
                                </h6>
                                <div class="content_with_action px-3 py-3">

                                    @if($leases->count())
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th class="font-weight-bold pt-0 text-left pb-0 pl-0 pr-0 dark-grey-text"><strong>{{trans('master.Reference_dashboard')}}</strong></th>
                                                    <th class="font-weight-bold pt-0 text-left pb-0 pl-0 pr-0 dark-grey-text"><strong>{{trans('master.Maturity Date')}}</strong></th>
                                                    <th class="font-weight-bold pt-0 text-left pb-0 pl-0 pr-0 dark-grey-text"><strong>{{trans('master.Description')}}</strong></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($leases as $lease)
                                                    <tr>
                                                        <td><a href="/leases/{{$lease->id}}/edit">{{trans('master.Lease')}} &nbsp; {{$lease->id}}</a></td>
                                                        <td>{!! $lease->maturity_date !!}</td>
                                                        <td>{!! \Carbon\Carbon::parse($lease->maturity_date)->diffForHumans() !!}
                                                            for {{ $lease->leaseType->lease_type_item }}
                                                             -
                                                            {!! $lease->leaseType->payment_type !!} </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else

                                        <div class="dashboardWrapper">
                                            {{trans('master.No upcoming events')}}
                                        </div>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 customColPadding">
                    <div class="card h-100" style="">
                        <div class="text-black text-left  d-flex align-items-start  py-2 px-2 rounded ">
                            <div class="text-center w-100">
                                <h6 class="text-left  card-header paddingLeftPointFour">
                                    <i class="fas fa-chart-bar fa-1x mr-1 primary-text-color"></i> <strong> {{trans('master.Liabilities per lease type')}}</strong>
                                </h6>
                                <div class="content_with_action px-3 py-3">

                                    <template id="pie2">
                                        <pie2 url="/api/liability-per-type">
                                        </pie2>
                                    </template>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 customColPadding">
                    <div class="card h-100" style="">
                        <div class="text-black text-left  d-flex align-items-start  py-2 px-2 rounded ">
                            <div class="text-center w-100">
                                <h6 class="text-left card-header paddingLeftPointFour">
                                    <i class="fas primary-text-color fa-chart-pie fa-1x mr-1 "></i> <strong> {{trans('master.Liabilities per lessor')}}</strong>
                                </h6>
                                <div class="content_with_action px-3 py-3">

                                    <template id="pie3">
                                        <pie3 url="/api/liability-per-lessor">
                                        </pie3>
                                    </template>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endif
    <!-- deals -->
@stop
@section('javascript')
    <!-- chart -->
    <script src="{{ mix('/tenant/app.js') }}"></script>

@stop

@push('additional-css')
    <style>
        .table td {
            text-align: left !important;
        }
    </style>
@endpush
