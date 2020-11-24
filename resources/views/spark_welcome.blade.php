@extends('website.views.layouts.master')
@push('meta')
    <meta name="description" content="LeaseAccounting.app helps international businesses achieve IFRS-16 compliance with ease. Start your 30-day free trial”">
    <meta name="author" content="LeaseAccounting Ltd">
    <title>Lease Accounting Software for IFRS-16 | LeaseAccounting.app</title>
@endpush
@section('content')
    <div id="app">
        <div id="home_part" class="content_ui_parent_holder">
            <div class="content_ui text-black">
                <header class="pt-lg-2 mt-lg-2 pb-lg-2 pb-md-2 pb-sm-2 mb-5 mt-5 pt-5 bg-img-repeat mt-md-5 mt-sm-5 mt-xs-5 pt-md-5 pt-sm-5 pt-xs-5 ">
                    <div class="page-header-content">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div>
                                    <h1 class="page-header-title text-lg-left text-md-center text-sm-center">Online Cloud Lease Accounting Software</h1>
                                    <p class="page-header-text text-lg-left text-md-center text-sm-center">Complying with IASB standard is a headache in
                                        Excel. LeaseAccounting.app helps international businesses achieve IFRS 16
                                        compliance with ease.
                                    </p>
                                    <div class="d-lg-flex"><a class="btn btn-sm btn-rounded  btn-primary-variant-main  px-5 waves-effect waves-light" href="{{route('register')}}">Free 30-day trial
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6"><img src="/img/compressed/mac_screen-min.png" alt="Lease accounting software" class="img-fluid"></div>
                        </div>
                    </div>
                </header>
            </div>
            <svg id="features_part" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 150">
                <path fill="#fff" fill-opacity="1"
                      d="M0,0L120,26.7C240,53,480,107,720,112C960,117,1200,75,1320,53.3L1440,32L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path>
            </svg>
        </div>
        <div  class="features_parent_holder">
            <div class="content_ui">
                <section class="bg-white py-10">
                    <div class="container">
                        <h2 class="h3-title">Core features that enterprise love</h2>
                        <div class="row mt-5 text-center">
                            <div class="col-lg-3 mb-5 mb-lg-0">
                                <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                </div>
                                <div class="h5-title">Foreign exchange</div>
                                <p class="mb-0">Multi-currency functionality that enables you to manage leases in multiple currencies.
                                </p>
                            </div>
                            <div class="col-lg-3 mb-5 mb-lg-0">
                                <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-filter">
                                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                    </svg>
                                </div>
                                <div class="h5-title">Validated reports</div>
                                <p class="mb-0">Reports with IFRS 16 calculations that have been validated by an international audit firm.
                                </p>
                            </div>
                            <div class="col-lg-3  mb-5 mb-lg-0">
                                <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    </svg>
                                </div>
                                <div class="h5-title">Audit trail</div>
                                <p class="mb-0">A fluid audit process that tracks all changes to transactions by time, date and user stamp.
                                </p>
                            </div>
                            <div class="col-lg-3  mb-5 mb-lg-0">
                                <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <div class="h5-title">Multi-user</div>
                                <p class="mb-0">Segregating duties between users is simple. You can amend and create new roles with custom rights if needed.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        {{--Slider component--}}
        <div id="how_it_works_part" class="pt-5">
        </div>
        <div class="position-relative  content_slider_holder_parent body_bg">
                    <div class="pb-5">
                        <div  class="content_ui pb-5 content_ui_padding text-black">
                            <div  class="mb-4 pt-4 h3-title">Introduction to LeaseAccounting.app</div>
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item pb-5" src="https://www.youtube.com/embed/-Z7c5m7j_Zg" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
            <svg id="faq_part"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 150">
                <path fill="#fff" fill-opacity="1"
                      d="M0,0L120,26.7C240,53,480,107,720,112C960,117,1200,75,1320,53.3L1440,32L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path>
            </svg>
        </div>
        {{--Faq area--}}
        <div  class="faq_parent_holder body_bg_white">
            <div class="h3-title">Frequently Asked Questions</div>
            <div class="content_ui">
                <div class="container">
                    <div class="row mb-10 mt-5">
                        <div class="col-lg-6 mb-5">
                            <div class="d-flex h-100">
                                <div class="icon-stack">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="question"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="" class="stack_svg">
                                        <path fill="currentColor" d="M202.021 0C122.202 0 70.503 32.703 29.914 91.026c-7.363 10.58-5.093 25.086 5.178 32.874l43.138 32.709c10.373 7.865 25.132 6.026 33.253-4.148 25.049-31.381 43.63-49.449 82.757-49.449 30.764 0 68.816 19.799 68.816 49.631 0 22.552-18.617 34.134-48.993 51.164-35.423 19.86-82.299 44.576-82.299 106.405V320c0 13.255 10.745 24 24 24h72.471c13.255 0 24-10.745 24-24v-5.773c0-42.86 125.268-44.645 125.268-160.627C377.504 66.256 286.902 0 202.021 0zM192 373.459c-38.196 0-69.271 31.075-69.271 69.271 0 38.195 31.075 69.27 69.271 69.27s69.271-31.075 69.271-69.271-31.075-69.27-69.271-69.27z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-black h5-title text-justify">How will I know that my leases will be fully IFRS 16 compliant?</div>
                                    <p class="text-black-50-custom text-justify">Our software is powered by ZenTreasury, one of the highest rated Lease Accounting Software on Capterra’s software directory, whose IFRS 16 calculations have been validated by an international audit firm.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <div class="d-flex h-100">
                                <div class="icon-stack flex-shrink-0 bg-teal text-black">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="question"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="" class="stack_svg">
                                        <path fill="currentColor" d="M202.021 0C122.202 0 70.503 32.703 29.914 91.026c-7.363 10.58-5.093 25.086 5.178 32.874l43.138 32.709c10.373 7.865 25.132 6.026 33.253-4.148 25.049-31.381 43.63-49.449 82.757-49.449 30.764 0 68.816 19.799 68.816 49.631 0 22.552-18.617 34.134-48.993 51.164-35.423 19.86-82.299 44.576-82.299 106.405V320c0 13.255 10.745 24 24 24h72.471c13.255 0 24-10.745 24-24v-5.773c0-42.86 125.268-44.645 125.268-160.627C377.504 66.256 286.902 0 202.021 0zM192 373.459c-38.196 0-69.271 31.075-69.271 69.271 0 38.195 31.075 69.27 69.271 69.27s69.271-31.075 69.271-69.271-31.075-69.27-69.271-69.27z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-black h5-title text-justify">Where is my data hosted?</div>
                                    <p class="text-black-50-custom text-justify">LeaseAccounting.app is a Software-as-a-Service (SaaS) application that is hosted on Google Cloud.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5 mb-lg-0">
                            <div class="d-flex h-100">
                                <div class="icon-stack flex-shrink-0 bg-teal text-black">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="question"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="" class="stack_svg">
                                        <path fill="currentColor" d="M202.021 0C122.202 0 70.503 32.703 29.914 91.026c-7.363 10.58-5.093 25.086 5.178 32.874l43.138 32.709c10.373 7.865 25.132 6.026 33.253-4.148 25.049-31.381 43.63-49.449 82.757-49.449 30.764 0 68.816 19.799 68.816 49.631 0 22.552-18.617 34.134-48.993 51.164-35.423 19.86-82.299 44.576-82.299 106.405V320c0 13.255 10.745 24 24 24h72.471c13.255 0 24-10.745 24-24v-5.773c0-42.86 125.268-44.645 125.268-160.627C377.504 66.256 286.902 0 202.021 0zM192 373.459c-38.196 0-69.271 31.075-69.271 69.271 0 38.195 31.075 69.27 69.271 69.27s69.271-31.075 69.271-69.271-31.075-69.27-69.271-69.27z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-black  h5-title text-justify">What currency rates are included?</div>
                                    <p class="text-black-50-custom text-justify">You can manually upload currency rates from a spreadsheet or enable automatic upload from ECB for EUR based companies or from Riksbanken for SEK based companies.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex h-100">
                                <div class="icon-stack flex-shrink-0 bg-teal text-black">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="question"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="" class="stack_svg">
                                        <path fill="currentColor" d="M202.021 0C122.202 0 70.503 32.703 29.914 91.026c-7.363 10.58-5.093 25.086 5.178 32.874l43.138 32.709c10.373 7.865 25.132 6.026 33.253-4.148 25.049-31.381 43.63-49.449 82.757-49.449 30.764 0 68.816 19.799 68.816 49.631 0 22.552-18.617 34.134-48.993 51.164-35.423 19.86-82.299 44.576-82.299 106.405V320c0 13.255 10.745 24 24 24h72.471c13.255 0 24-10.745 24-24v-5.773c0-42.86 125.268-44.645 125.268-160.627C377.504 66.256 286.902 0 202.021 0zM192 373.459c-38.196 0-69.271 31.075-69.271 69.271 0 38.195 31.075 69.27 69.271 69.27s69.271-31.075 69.271-69.271-31.075-69.27-69.271-69.27z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-black h5-title text-justify">When will I be charged?</div>
                                    <p class="text-black-50-custom text-justify">
                                        You will not be charged until the free trial is over. You can cancel anytime during the free trial without any charge!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <svg id="#last-call-toaction-svg"xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 150" ><path fill="#028CDE" fill-opacity="1" d="M0,0L120,26.7C240,53,480,107,720,112C960,117,1200,75,1320,53.3L1440,32L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path></svg>
        <div class="last_call_to_register">
            <div class="content_ui pb-4">
                <div class="container text-white">
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-lg-8 col-md-10 text-center my-10 py-10">
                            <div class="mb-4 pt-4 h3-title">Ready to get Started?</div>
                            <a class="btn btn-sm  btn-primary-variant-one  px-5 waves-effect waves-light" href="{{route('register')}}">FREE TRIAL</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('header-scripts-area')
    <link rel="stylesheet" href="{{ mix('/css/website.css') }}">
    <style>
        #features_part, #faq_part{
            overflow: hidden;
            vertical-align: middle;
            position: absolute;
            bottom: 0;
            left: 0;
        }
        #last-call-toaction-svg{
            overflow: hidden; vertical-align: middle;
        }
    </style>
@endpush
@push('footer-scripts-top')
    <script src="{{ mix('/app/website-components/app.js') }}"></script>
@endpush