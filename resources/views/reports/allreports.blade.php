@extends('layouts.master')

@section('content')
    <div id="all_reports">
        <div class="row row-eq-height">
            <div class="col-md-4 d-flex align-items-stretch pt-0  pb-2 mb-4">
                <div class="card w-100" style="">
                    <div class="text-black text-left  d-flex align-items-start  py-2 px-2 rounded ">
                        <div>
                            <h6 class="white-text  card-header paddingLeftPointFour">
                                <strong> {{trans('master.Change Report')}}</strong>
                            </h6>
                            <div class="content_with_action">

                                <p class="pb-2  px-1 text-left pt-2">
                                    {{trans('master.change-report-text')}}
                                </p>
                                <div class="action_area pb-3 px-5 d-flex justify-content-around">
                                    <div class="action mx-3 my-3">
                                        <div>
                                            <a class="btn btn-sm lease-report-button  btn-primary"
                                               href="/reporting/change-lease">

                                                {{trans('master.Go to')}}
                                            </a>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex align-items-stretch pt-0  pb-2 mb-4">
                <div class="card w-100" style="">
                    <div class="text-black text-left d-flex align-items-start  py-2 px-2 rounded ">
                        <div>
                            <h6 class="white-text  card-header paddingLeftPointFour">
                                <strong> {{trans('master.Lease Payments')}}</strong>
                            </h6>
                            <div class="content_with_action">

                                <p class="pb-2  px-1 text-left pt-2">
                                    {{trans('master.payment-report-text')}}
                                </p>
                                <div class="action_area pb-3 px-5 d-flex justify-content-around">
                                    <div class="action mx-3 my-3">
                                        <div>
                                            <a class="btn btn-sm lease-report-button  btn-primary"
                                               href="/reporting/month-payment">

                                                {{trans('master.Go to')}}
                                            </a>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-4 d-flex align-items-stretch pt-0  pb-2 mb-4">
                <div class="card w-100" style="">
                    <div class="text-black text-left d-flex align-items-start  py-2 px-2 rounded ">
                        <div>
                            <h6 class="white-text  card-header paddingLeftPointFour">
                                <strong> {{trans('master.Lease Month End')}}</strong>
                            </h6>
                            <div class="content_with_action">

                                <p class="pb-2  px-1 text-left pt-2">
                                    {{trans('master.month-end-report-text')}}
                                </p>
                                <div class="action_area pb-3 px-5 d-flex justify-content-around">
                                    <div class="action mx-3 my-3">
                                        <div>
                                            <a class="btn btn-sm lease-report-button  btn-primary"
                                               href="/reporting/month-value">

                                                {{trans('master.Go to')}}
                                            </a>

                                        </div>
                                    </div>

                                </div>

                            </div>


                        </div>
                    </div>
                </div>


            </div>

            <div class="col-md-4 d-flex align-items-stretch pt-0  pb-2 mb-4">
                <div class="card w-100" style="">
                    <div class="text-black text-left d-flex align-items-start  py-2 px-2 rounded ">
                        <div>
                            <h6 class="white-text  card-header paddingLeftPointFour">
                                <strong> {{trans('master.Notes Maturity Report')}}</strong>
                            </h6>
                            <div class="content_with_action">

                                <p class="pb-2  px-1 text-left pt-2">
                                    {{trans('master.notes-maturity-report-text')}}
                                </p>
                                <div class="action_area pb-3 px-5 d-flex justify-content-around">
                                    <div class="action mx-3 my-3">
                                        <div>
                                            <a class="btn btn-sm lease-report-button  btn-primary"
                                               href="/reporting/notes-maturity">

                                                {{trans('master.Go to')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($buttonShow['lease_valuation_report'])
            <div class="col-md-4 d-flex align-items-stretch pt-0  pb-2 mb-4">
                <div class="card w-100" style="">
                    <div class="text-black text-left d-flex align-items-start  py-2 px-2 rounded ">
                        <div>
                            <h6 class="white-text  card-header paddingLeftPointFour">
                                <strong> {{trans('master.Lease Valuation Report')}}</strong>
                            </h6>
                            <div class="content_with_action">

                                <p class="pb-2  px-1 text-left pt-2">
                                    {{trans('master.valuation-report-text')}}
                                </p>
                                <div class="action_area pb-3 px-5 d-flex justify-content-around">
                                    <div class="action mx-3 my-3">
                                        <div>
                                            <a class="btn btn-sm lease-report-button  btn-primary"
                                               href="/reporting/lease-valuation">

                                                {{trans('master.Go to')}}
                                            </a>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($buttonShow['lease_summary_report'])
            <div class="col-md-4 d-flex align-items-stretch pt-0  pb-2 mb-4">
                <div class="card w-100" style="">
                    <div class="text-black text-left d-flex align-items-start  py-2 px-2 rounded ">
                        <div>
                            <h6 class="white-text  card-header paddingLeftPointFour">
                                <strong> {{trans('master.Lease summary report')}}</strong>
                            </h6>
                            <div class="content_with_action">

                                <p class="pb-2  px-1 text-left pt-2">
                                    {{trans('master.summary-report-text')}}
                                </p>
                                <div class="action_area pb-3 px-5 d-flex justify-content-around">
                                    <div class="action mx-3 my-3">
                                        <div>
                                            <a class="btn btn-sm lease-report-button  btn-primary"
                                               href="/reporting/lease-summary">

                                                {{trans('master.Go to')}}
                                            </a>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($buttonShow['ytd_report'])
                <div class="col-md-4 d-flex align-items-stretch pt-0  pb-2 mb-4">
                    <div class="card w-100" style="">
                        <div class="text-black text-left d-flex align-items-start  py-2 px-2 rounded ">
                            <div>
                                <h6 class="white-text  card-header paddingLeftPointFour">
                                    <strong> {{trans('master.Lease summary report YTD')}}</strong>
                                </h6>
                                <div class="content_with_action">

                                    <p class="pb-2  px-1 text-left pt-2">
                                        {{trans('master.summary-report-ytd-text')}}
                                    </p>
                                    <p class="pb-2  px-1 text-left">
                                        {{trans('master.In this report we just bring numbers from Lease changes, payments and month end report. If you want to make postings only on summary level you can just simply use this report for that purpose. The reports lists year-to-date numbers to each entity selected into the report. One column is one entity.')}}
                                    </p>
                                    <div class="action_area pb-3 px-5 d-flex justify-content-around">
                                        <div class="action mx-3 my-3">
                                            <div>
                                                <a class="btn btn-sm lease-report-button  btn-primary"
                                                   href="/reporting/lease-summary-ytd">

                                                    {{trans('master.Go to')}}
                                                </a>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($buttonShow['rou_by_lease_type_report'])
            <div class="col-md-4 d-flex align-items-stretch pt-0  pb-2 mb-4">
                <div class="card w-100" style="">
                    <div class="text-black text-left d-flex align-items-start  py-2 px-2 rounded ">
                        <div>
                            <h6 class="white-text  card-header paddingLeftPointFour">
                                <strong> {{trans('master.RoU Asset by Lease Type')}}</strong>
                            </h6>
                            <div class="content_with_action">

                                <p class="pb-2  px-1 text-left pt-2">
                                    {{trans('master.rou-report-text')}}
                                </p>
                                <div class="action_area pb-3 px-5 d-flex justify-content-around">
                                    <div class="action mx-3 my-3">
                                        <div>
                                            <a class="btn btn-sm lease-report-button  btn-primary"
                                               href="/reporting/rou-asset-lease-type">

                                                {{trans('master.Go to')}}
                                            </a>

                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($buttonShow['addition_to_liability_report'])
            <div class="col-md-4 d-flex align-items-stretch pt-0  pb-2 mb-4">
                <div class="card w-100" style="">
                    <div class="text-black text-left d-flex align-items-start  py-2 px-2 rounded ">
                        <div>
                            <h6 class="white-text  card-header paddingLeftPointFour">
                                <strong> {{trans('master.Additions to Lease Liability')}}</strong>
                            </h6>
                            <div class="content_with_action">

                                <p class="pb-2  px-1 text-left pt-2">
                                    {{trans('master.addition-lease-liability')}}
                                </p>
                                <p class="pb-2  px-1 text-left">
                                    {{trans('master.In this report split all the RoU Asset posting items by lease type.')}}
                                </p>
                                <div class="action_area pb-3 px-5 d-flex justify-content-around">
                                    <div class="action mx-3 my-3">
                                        <div>
                                            <a class="btn btn-sm lease-report-button  btn-primary"
                                               href="/reporting/additions-lease-liability">

                                                {{trans('master.Go to')}}
                                            </a>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($buttonShow['addition_to_rou_report'])
            <div class="col-md-4 d-flex align-items-stretch pt-0  pb-2 mb-4">
                <div class="card w-100" style="">
                    <div class="text-black text-left d-flex align-items-start  py-2 px-2 rounded ">
                        <div>
                            <h6 class="white-text  card-header paddingLeftPointFour">
                                <strong> {{trans('master.Additions to Right of Use Asset')}}</strong>
                            </h6>
                            <div class="content_with_action">

                                <p class="pb-2  px-1 text-left pt-2">
                                    {{trans('master.In this report we list all values that has been added to RoU Asset to each lease agreement. So the items areLease payments made on or before commencement date,Initial direct cost,Estimated cost for dismantling restoring asset,Incentives received and Residual value.')}}
                                </p>

                                <p class="pb-2  px-1 text-left">
                                    {{trans('master.addition-rou-asset')}}
                                </p>
                                <div class="action_area pb-3 px-5 d-flex justify-content-around">
                                    <div class="action mx-3 my-3">
                                        <div>
                                            <a class="btn btn-sm lease-report-button  btn-primary"
                                               href="/reporting/additions-right-asset">

                                                {{trans('master.Go to')}}
                                            </a>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($buttonShow['facility_overview_report'])
                <div class="col-md-4 d-flex align-items-stretch pt-0  pb-2 mb-4">
                    <div class="card w-100" style="">
                        <div class="text-black text-left d-flex align-items-start  py-2 px-2 rounded ">
                            <div>
                                <h6 class="white-text  card-header paddingLeftPointFour">
                                    <strong> {{trans('master.Facility overview report')}}</strong>
                                </h6>

                                <div class="content_with_action">

                                    <p class="pb-2  px-1 text-left pt-2">
                                        {{trans('master.facility overview report')}}
                                    </p>

                                    <p class="pb-2  px-1 text-left">
                                        {{trans('master.facility overview report1')}}
                                    </p>
                                    <div class="action_area pb-3 px-5 d-flex justify-content-around">
                                        <div class="action mx-3 my-3">
                                            <div>
                                                <a class="btn btn-sm lease-report-button  btn-primary"
                                                   href="/reporting/facility-overview">

                                                    {{trans('master.Go to')}}
                                                </a>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


        </div>
    </div>
@stop
