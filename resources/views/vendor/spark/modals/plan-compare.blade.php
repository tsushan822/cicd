<!-- Modal Pricing Comparison-->
<div class="modal  fade compare_plan_modal" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered compare_plan_modal_dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close d-flex mt-1"><span aria-hidden="true">×</span></button>
                    <div class="d-flex px-3 pr-5  justify-content-between pt-3 pb-2">
                        <h3>Compare available plans</h3>
                        <br>
                        <div class="custom-control position-relative custom-switch">
                            <small class="monthly_small">Monthly</small>
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" v-model="monthlyPlanSwitch">
                            <label class="custom-control-label" for="customSwitch1"></label>
                            <small class="yearly_small">Yearly</small>
                            <span class="badge badge-primary discount_badge">20% off</span>
                        </div>
                    </div>
                    <div class="compare_palns_area">
                        <div class="card-deck text-dark  pt-3">
                            <div class="card pricing-card">
                                <div class="card-body">
                                    <h6 class="font-weight-bold blue-text text-uppercase ml-3 mb-4">Basic</h6>
                                    <p class="price_text ml-3 font-weight-normal"><span>$</span><span v-if="monthlyPlanSwitch">1990</span><span v-else>199</span><span v-if="monthlyPlanSwitch">/year</span><span v-else>/month</span></p>
                                    <div class="pricing_text_and_button d-flex flex-column justify-content-between ">
                                        <p class="px-3 text-left">A simple and powerful way to get IFRS-16 compliance.</p>
                                    </div>
                                    <div class="plan_promo text-left pl-3 mt-3">
                                        Get the following features and reports
                                    </div>
                                    <h6 class="text-center mt-4 basic_hidden_plus"><b></b></h6>
                                    <div class="pricing_feature_list mt-2 px-3 padding_1rem">
                                        <h6 class="padding_1rem text-left px-3">Features included</h6>
                                        <hr>
                                        <ul class="mb-0 price_text_ul px-3">
                                            <li class="text-left">
                                                <p><strong>2</strong> users</p>
                                            </li>
                                            <li class="text-left">
                                                <p><strong>20</strong> leases</p>
                                            </li>
                                            <li class="text-left">
                                                <p>Foreign exchange</p>
                                            </li>
                                            <li class="text-left">
                                                <p>View and export lease flow schedules</p>
                                            </li>
                                            <li class="text-left">
                                                <p>Company register</p>
                                            </li>
                                            <li class="text-left">
                                                <p>Searchable lease register</p>
                                            </li>
                                            <li class="text-left">
                                                <p>Portfolios</p>
                                            </li>
                                            <li class="text-left">
                                                <p class="pb-0">Cost centers</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="pricing_report_list mt-2 px-3 ">
                                        <h6 class="padding_1rem text-left px-3">Reports included</h6>
                                        <hr>
                                        <ul class="mb-0 px-3 price_text_ul">
                                            <custom-pricing inline-template v-cloak>
                                                <report-revealer :muted="[5,4,6,7,8,9,10,11,12,13,14]"></report-revealer>
                                            </custom-pricing>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card pricing-card">
                                <div class="card-body">
                                    <h6 class="font-weight-bold ml-3 blue-text text-uppercase mb-4">PROFESSIONAL</h6>
                                    <p class="price_text ml-3 font-weight-normal"><span>$</span><span v-if="monthlyPlanSwitch">3990</span><span v-else>399</span><span v-if="monthlyPlanSwitch">/year</span><span v-else>/month</span></p>
                                    <div class="pricing_text_and_button d-flex flex-column justify-content-between">
                                        <p class="px-3 text-left">Level up with better reporting functionalities.</p>
                                    </div>
                                    <div class="plan_promo text-left pl-3 mt-3">
                                        Get all basic features and reports
                                    </div>
                                    <h6 class="text-center mt-4"><b>Plus</b></h6>
                                    <div class="pricing_feature_list mt-2 px-3 padding_1rem">
                                        <h6 class="padding_1rem text-left px-3">Features included</h6>
                                        <hr>
                                        <ul class="mb-0 price_text_ul px-3">
                                            <li class="text-left">
                                                <p><strong>5</strong> users</p>
                                            </li>
                                            <li class="text-left">
                                                <p><strong>50</strong> leases</p>
                                            </li>
                                            <li class="text-left">
                                                <p><strong>Email</strong> notifications</p>
                                            </li>
                                            <li class="text-left">
                                                <p>Report templates</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="pricing_report_list mt-2 px-3 ">
                                        <h6 class="padding_1rem text-left px-3">Reports included</h6>
                                        <hr>
                                        <ul class="mb-0 px-3 price_text_ul">
                                            <custom-pricing inline-template v-cloak>
                                                <report-revealer :muted="[0,1,2,3,4,10,11,12,13,14]"></report-revealer>
                                            </custom-pricing>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card pricing-card">
                                <div class="card-body">
                                    <h6 class="font-weight-bold blue-text ml-3 text-uppercase mb-4">Business</h6>
                                    <p class="price_text ml-3 font-weight-normal"><span>$</span><span v-if="monthlyPlanSwitch">6990</span><span v-else>699</span><span v-if="monthlyPlanSwitch">/year</span><span v-else>/month</span></p>
                                    <div class="pricing_text_and_button d-flex flex-column justify-content-between">
                                        <p class="px-3 text-left">For businesses managing multiple subsidiaries and facilities.</p>
                                    </div>
                                    <div class="plan_promo text-left pl-3 mt-3">
                                        Get all professional features and reports
                                    </div>
                                    <h6 class="text-center mt-4"><b>Plus</b></h6>
                                    <div class="pricing_feature_list mt-2 px-3 padding_1rem">
                                        <h6 class="padding_1rem text-left px-3">Features included</h6>
                                        <hr>
                                        <ul class="mb-0 price_text_ul px-3">
                                            <li class="text-left">
                                                <p><strong>10</strong> users</p>
                                            </li>
                                            <li class="text-left">
                                                <p><strong>400</strong> leases</p>
                                            </li>
                                            <li class="text-left">
                                                <p>Cost center split</p>
                                            </li>
                                            <li class="text-left">
                                                <p>Calculate valuation</p>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="pricing_report_list mt-2 px-3 ">
                                        <h6 class="padding_1rem text-left px-3">Reports included</h6>
                                        <hr>
                                        <ul class="mb-0 px-3 price_text_ul">
                                            <custom-pricing inline-template v-cloak>
                                                <report-revealer :muted="[0,1,2,3,5,6,7,8,9,11,12,13,14]"></report-revealer>
                                            </custom-pricing>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer px-5">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@push('additional-css-spark')
    <style>
        .compare_plan_modal >.modal-dialog {
            max-width: 1400px;
            width: calc(100vw - 100px);
            z-index: 9999999999;
        }
        .pricing_feature_list {
            min-height: 456px !important;
        }
        .monthly_small{
            position: relative;
            left: -40px;
            top: 2px;
        }
        .yearly_small{
            position: relative;
            left: -2px;
            top: 2px;
        }
        .discount_badge{
            position: absolute;
            right: -12px;
            top: -15px;
        }
        .report_li .details{
            margin-top: 15px;
        }
        .package_selected{
            top: 0px;
            right: 0px;
            padding: .4rem .5rem;
            font-size: .8rem;
            position: absolute;
        }
    </style>
@endpush