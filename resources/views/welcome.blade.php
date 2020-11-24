@extends('layouts.dashboard')
@section('css')
    <!-- Datatables -->
    <style>


    </style>


@stop
@section('content')

    <div class="container my-5 py-5">


        <!-- Section: Block Content -->
        <section>

            <div class="col-lg-3 col-md-6 mb-4">

                {{--<a href="{!! route('leases.index') !!}">--}}
                <a href="#">
                    <div class="media displayBlock white z-depth-1 rounded">
                        <div class="metro  front">
                            <div class="teal z-depth-1  rounded-left text-white ">
                                @include('icons.leasesLarge')
                            </div>
                        </div>
                        <div class="media-body p-1">
                            <h5 class="font-weight-bold mb-0 pb-2 pt-2">@lang('master.Leasing')</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">

                <a href="/dashboard/lease">
                    <div class="media displayBlock white z-depth-1 rounded">
                        <div class="metro  front">
                            <div class="teal z-depth-1  rounded-left text-white ">
                                @include('icons.dashboardLarge')
                            </div>
                        </div>
                        <div class="media-body p-1">
                            <h5 class="font-weight-bold mb-0 pb-2 pt-2">@lang('master.Leasing')</h5>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-lg-6 col-md-6 mb-4">

               {{-- <a href="{!! route('lease-types.index') !!}">--}}
                <a href="#">
                    <div class="media displayBlock white z-depth-1 rounded">
                        <div class="metro  front">
                            <div class="teal z-depth-1  rounded-left text-white ">
                                @include('icons.leasesLarge')
                            </div>
                        </div>
                        <div class="media-body p-1">
                            <h5 class="font-weight-bold mb-0 pb-2 pt-2">@lang('master.Lease types')</h5>
                        </div>
                    </div>
                </a>
            </div>

            <!--Grid row-->

        </section>
        <!-- Section: Block Content -->


    </div>




@stop
@section('javascript')
@stop