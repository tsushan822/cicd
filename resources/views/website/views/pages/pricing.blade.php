@extends('website.views.layouts.master')
@push('meta')
    <meta name="description" content="pricing description">
    <meta name="author" content="LeaseAccounting Ltd">
    <title>pricing</title>
    <meta property="og:title" content="pricing description" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:description" content="pricing description" />
@endpush
@section('content')
    <div>
        <div class="blog_parent_holder pb-5 position-relative">
            <div class="content_ui pb-4 text-black">
                <header class="pt-lg-2 mt-lg-2 pb-lg-0 pb-md-0 pb-sm-2  mt-5 pt-5 bg-img-repeat mt-md-5 mt-sm-5 mt-xs-5 pt-md-5 pt-sm-5 pt-xs-5 ">
                    <div class="page-header-content">
                        <div class="row mt-5 ">
                            <div class="col-lg-12 text-white col-md-12 col-sm-12">
                                <div class="pl-3  pt-2">
                                    <h1 class="page-header-title text-dark text-center">Free 30 days of trial</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </div>
            <svg id="features_part" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 150" style="overflow: hidden; vertical-align: middle; position: absolute; bottom: 0px; left: 0px;"><path fill="#fff" fill-opacity="1" d="M0,0L120,26.7C240,53,480,107,720,112C960,117,1200,75,1320,53.3L1440,32L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path></svg>
        </div>
    </div>
    <div id="app" class="blog_listing_holder position-relative pb-5">
        <div class="content_ui text-dark">
            <section class="text-center dark-grey-text">
                <div class="card-deck">
                    <div class="card pricing-card">
                        <div class="card-body">
                            <h6 class="font-weight-bold blue-text text-uppercase mb-4">Basic</h6>
                            <p class="price_text font-weight-normal"><span>$</span>199<span>/month</span></p>
                            <div class="pricing_text_and_button d-flex flex-column justify-content-between ">
                                <p class="px-3 text-left">A simple and powerful way to get IFRS-16 compliance.</p>

                                <a href="/register" class="btn btn-sm
                                btn-primary-variant-main  px-5 waves-effect waves-light">Free 30-day trial
                                </a>
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
                                        <p><strong>20</strong> leases (1$ per 2 additional Leases)</p>
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
                                    <report-reveal-component :muted="[5,4,6,7,8,9,10,11,12,13,14]"></report-reveal-component>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card pricing-card">
                        <div class="card-body">
                            <h6 class="font-weight-bold blue-text text-uppercase mb-4">PROFESSIONAL</h6>
                            <p class="price_text font-weight-normal"><span>$</span>399<span>/month</span></p>
                            <div class="pricing_text_and_button d-flex flex-column justify-content-between">
                                <p class="px-3 text-left">Level up with better reporting functionalities.</p>

                                <a href="/register" class="btn btn-sm
                                btn-primary-variant-main  px-5 waves-effect waves-light">Free 30-day trial
                                </a>

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
                                        <p><strong>50</strong> leases (1$ per 2 additional Leases)</p>
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
                                    <report-reveal-component :muted="[0,1,2,3,4,10,11,12,13,14]"></report-reveal-component>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card pricing-card">
                        <div class="card-body">
                            <h6 class="font-weight-bold blue-text text-uppercase mb-4">Business</h6>
                            <p class="price_text font-weight-normal"><span>$</span>699<span>/month</span></p>
                            <div class="pricing_text_and_button d-flex flex-column justify-content-between">
                                <p class="px-3 text-left">For businesses managing multiple subsidiaries and facilities.</p>
                                <a href="/register" class="btn btn-sm btn-primary-variant-main  px-5 waves-effect
                                waves-light">Free 30-day trial
                                </a>
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
                                        <p><strong>400</strong> leases (1$ per 2 additional Leases)</p>
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
                                    <report-reveal-component :muted="[0,1,2,3,5,6,7,8,9,11,12,13,14]"></report-reveal-component>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Grid column -->
                    <div class="card pricing-card">
                        <div class="card-body">
                            <h6 class="font-weight-bold blue-text text-uppercase mb-4">Enterprise</h6>
                            <div class="ribbon ribbon-top-right"><span><img src="https://www.zentreasury.com/favicon-16x16.png">ZenTreasury</span></div>
                            <p class="price_text font-weight-normal">Contact</p>
                            <div class="pricing_text_and_button d-flex flex-column justify-content-between">
                                <p class="px-3 text-left">For large enterprises looking to export accounting vouchers to their ERPs.</p>
                                <a href="https://www.zentreasury.com/" target="_blank" class="btn btn-sm
                                btn-primary-variant-main
                                 px-5 waves-effect
                                waves-light">Request Pricing
                                </a>
                            </div>
                            <div class="plan_promo text-left pl-3 mt-3">
                                Get all business features and reports
                            </div>
                            <h6 class="text-center mt-4"><b>Plus</b></h6>
                            <div class="pricing_feature_list mt-2 px-3 padding_1rem">
                                <h6 class="padding_1rem text-left px-3">Features included</h6>
                                <hr>
                                <ul class="mb-0 price_text_ul px-3">
                                    <li class="text-left">
                                        <p><strong>Unlimited</strong> users</p>
                                    </li>
                                    <li class="text-left">
                                        <p><strong>Unlimited</strong> leases</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="pricing_report_list mt-2 px-3 ">
                                <h6 class="padding_1rem text-left px-3">Reports included</h6>
                                <hr>
                                <ul class="mb-0 px-3 price_text_ul">
                                    <report-reveal-component :muted="[0,1,2,3,4,5,6,7,8,9,10]"></report-reveal-component>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                </div>
            </section>
        </div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 150" style="overflow: hidden; vertical-align: middle;"><path fill="#028CDE" fill-opacity="1" d="M0,0L120,26.7C240,53,480,107,720,112C960,117,1200,75,1320,53.3L1440,32L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path></svg>

    <div class="last_call_to_register"><div class="content_ui pb-4"><div class="container text-white"><div class="row justify-content-center"><div class="col-xl-6 col-lg-8 col-md-10 text-center my-10 py-10"><h3 class="mb-4 pt-4 ">Ready to get Started?</h3>  <a href="{{route('register')}}" class="btn btn-sm btn-rounded  btn-primary-variant-one  px-5 waves-effect waves-light">FREE TRIAL</a></div></div></div></div></div>
@endsection
@push('header-scripts-area')
    <link rel="stylesheet" href="{{ mix('/css/website.css') }}">
@endpush

@push('footer-scripts-top')
    <script src="{{ mix('/app/website-components/app.js') }}"></script>
@endpush