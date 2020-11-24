@extends('website.views.layouts.master')
@push('meta')
    <meta name="description" content="Lease managaement/accounting system for small business to enterprise.">
    <meta name="author" content="LeaseAccounting Ltd">
    <title>Try LeaseAccounting software for 30 days.</title>
@endpush
@push('header-scripts-area')
    <style>
        body{
            background:#EFFAFD !important
        }
        .header_ui_area, .footer_area{
            display:none
        }
        .sub {
            font-size: 16px;
            letter-spacing: .8px;
            font-weight: 200;
            opacity: .75;
            margin-bottom: 1rem !important;
        }
        .onboarding__nav__step {
            opacity: .3;
            margin-bottom: 30px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }
        .onboarding__nav__step .onboarding__nav__step__number {
            min-width: 33px;
            width: 33px;
            height: 33px;
            text-align: center;
            display: inline-block;
            border-radius: 50px;
            background: white;
            color: #028CDE;
            font-size: 22px;
            margin-right: 20px;
        }
        .onboarding__nav__step__title {
            font-size: 1.3rem;
            line-height: 1.5rem;
            margin-top: 7px;
        }
        .custom_registration_nav_top h3 {
            font-size: 1.5rem;
            line-height: 1.7rem;
            margin-bottom: 15px;
        }
        .custom_registration_nav_ul {
            margin-top: 4rem
        }
        .left_custom_registartion {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
            background: #147ab5;
            padding: 40px;
        }
        .onboarding__nav__step.active {
            opacity: 1;
        }
        .right_custom_registartion {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            background: white;
            padding: 40px;
            color: black;
        }
        .right_custom_registartion h3 {
            font-size: 1.5rem;
            font-weight: 300;
            margin-top:1.5rem;
            margin-bottom: 1.5rem !important;
        }
        .nav_back{
            position: absolute;
            top: 30px;
            left: 40px;
            letter-spacing: 2px;
            cursor: pointer;
        }
        .step-number {
            position: absolute;
            top: 30px;
            right: 30px;
            letter-spacing: 2px;
        }
        .readme {
            padding: 20px;
            border-radius: 5px;
            background: #effafd;
            font-size: 14px;
            font-weight: 300;
            margin-bottom: 1rem !important;
        }
        .completed-step {
            text-decoration: line-through;
        }
        .country-select{
            border: transparent;
            position: relative;
            left: 12px;
            top: -10px;
            width: 97%;
            color: #abb7c4;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            opacity: .8;
        }
        .terms-and-service-checkbox{
            display: block !important;
        }
        .terms-and-service-checkbox-input{
            position: relative !important;
            pointer-events: unset !important;
            opacity: unset !important;
            top: -3px !important;
            margin-right: 7px;
        }
        .link-custom-position{
            margin-left: 4px;
            position: relative;
            top: 1px;
        }
        .countryLabel {
            margin-top: -.3rem;
            margin-left: 2.7rem !important;
            color: #abb7c4 !important
        }
        #card-element .__PrivateStripeElement{
            position: relative;
            top: -11px;
        }
        .vat-info-area{
            color: white;
            background-color: #028CDE;
            border-color: #028CDE;
        }
        .invalid-feedback {
            margin-left: 2.5rem
        }
        .form-control::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #aab7c4;
            opacity: 1; /* Firefox */
            font-family:nunito;
        }

        .form-control:-ms-input-placeholder { /* Internet Explorer 10-11 */
            color: #aab7c4;
            font-family:nunito;
        }

        .form-control::-ms-input-placeholder { /* Microsoft Edge */
            color: #aab7c4;
            font-family:nunito;
        }
        [v-cloak] {
            display: none
        }
        .md-form .prefix {
            top: .9rem;
            font-size: 1.75rem;
            left:0;
        }
        .countries_fa {
            top: 0.2rem !important;
        }
        .md-form input::placeholder {
            color: #abb7c4 !important;
        }
        .md-form label {
            color: #abb7c4;
        }
        .right_custom_registartion .fas {
            color: #028CDE !important;
        }
        .md-form input:not([type]):focus:not([readonly]), .md-form input[type=date]:not(.browser-default):focus:not([readonly]), .md-form input[type=datetime-local]:not(.browser-default):focus:not([readonly]), .md-form input[type=datetime]:not(.browser-default):focus:not([readonly]), .md-form input[type=email]:not(.browser-default):focus:not([readonly]), .md-form input[type=number]:not(.browser-default):focus:not([readonly]), .md-form input[type=password]:not(.browser-default):focus:not([readonly]), .md-form input[type=search-md]:focus:not([readonly]), .md-form input[type=search]:not(.browser-default):focus:not([readonly]), .md-form input[type=tel]:not(.browser-default):focus:not([readonly]), .md-form input[type=text]:not(.browser-default):focus:not([readonly]), .md-form input[type=time]:not(.browser-default):focus:not([readonly]), .md-form input[type=url]:not(.browser-default):focus:not([readonly]), .md-form textarea.md-textarea:focus:not([readonly]) {
            border-bottom: 1px solid #028CDE;
            box-shadow: 0 1px 0 0 #028CDE;
        }
        .md-form label.active {
            transform: translateY(-14px) scale(.8);
            color: #028CDE !important
        }
        .btn {
            color: #FFFFFF !important;
            background-color: #028CDE !important;
        }
        .link_custom_color {
            color: #028CDE
        }
        /* Enter and leave animations can use different */
        /* durations and timing functions.              */
        .slide-fade-enter-active {
            transition: all .3s ease;
        }
        .slide-fade-leave-active {
            transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
        }
        .slide-fade-enter, .slide-fade-leave-to
            /* .slide-fade-leave-active below version 2.1.8 */ {
            transform: translateX(10px);
            opacity: 0;
        }
    </style>
    <style>
        .compare_plan_modal > .modal-dialog {
            max-width: 1400px;
            width: calc(100vw - 100px);
            z-index: 9999999999;
        }
        .modal-content, .modal-header, .modal-body, .compare_palns_area, section.pricing {
            color: white !important;
        }
        #exampleModalLong {
            background: white;
        }
        .compare_plan_close {
            color: #fff;
            opacity: 1;
            font-weight: 300;
        }
        .plan_promo {
            font-size: 12px;
            color: #008cde;
            margin-left: 6px;
            margin-top: 6px;
        }
        .plan_promo i {
            margin-right: 5px
        }
        .compare_plan_modal_card_body {
            color: #525f7e;
        }
        .fa-li > .fa-check {
            color: #53db6f;
            margin-right: 8px;
        }
        .fa-li > .fa-times {
            color: red;
            margin-right: 8px;
        }
        .plan-p {
            margin-bottom: 0;
            font-size: 18px;
        }
        .plan-p i {
            margin-right: 15px;
        }
        .modal_title_compare_paln {
            font-size: 32px;
        }
        .bg-white-custom{
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            box-shadow:0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
            background-color: #fff!important;
        }
        .bg-white-custom .card{
            box-shadow:unset !important;
        }
    </style>
@endpush
@push('header-scripts-area')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.Spark = <?php echo json_encode(array_merge(Spark::scriptVariables(), [])); ?>;
    </script>
@endpush
@section('content')
    <section id="spark-app" class="mt-3  h-100 mb-5 py-3 ">
        <spark-register-stripe inline-template v-cloak>
            <div>
                <div class="container  d-flex justify-content-center align-items-center">
                    <div class="row flex-center ">
                        <div class="col-md-12 mb-5">
                            <a href="/"><img src="../img/logo-blue.svg" alt="" class="srcimg" style="width:120px"></a>
                        </div>
                        <div class="col-md-12">
                            <div class="container">

                                <div class="row">
                                    <div class="col-md-12 right_custom_registartion">
                                        {{--Navigation with information --}}
                                        <custom-navigation :stepnumber="currentStep" @previous-step="previousStep()"></custom-navigation>
                                        <div>
                                            <div class="spark-screen container">
                                                {{--Company details and authentication related form--}}
                                                <transition name="slide-fade">
                                                    <div v-show="currentStep===0">
                                                        @include('spark::auth.company-details')
                                                    </div>
                                                </transition>
                                                {{--Pricing table to select a plan--}}
                                                <transition name="slide-fade">
                                                    <div v-show="currentStep===1">
                                                        @include('spark::auth.pricing-details')
                                                    </div>
                                                </transition>
                                                {{--Checkout with address and vat information--}}
                                                <transition name="slide-fade">
                                                    <div v-show="currentStep===2">
                                                        @include('spark::auth.checkout-details')
                                                    </div>
                                                </transition>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </spark-register-stripe>
    </section>
    @push('footer-scripts')
        <script src="{{ mix('js/app.js') }}"></script>
    @endpush
@endsection
@push('header-scripts-area')
    <link rel="stylesheet" href="{{ mix('/css/website.css') }}">
@endpush
@push('footer-scripts')

@endpush
@push('footer-scripts-top')
@endpush