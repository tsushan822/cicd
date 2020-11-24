{{--<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Lease managaement system">
    <meta name="author" content="LeaseAccounting.app">
    <meta name="csrf-token" id="csrf-token" content="{{csrf_token()}}">
    <title>Leaseaccounting.app</title>
    @include('sub-views.favicon')
    @yield('css')
    <link rel="stylesheet" href="/auth-assets/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
<div class="container-fluid">
    <div class="row no-gutter">
        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
        <div class="col-md-8 col-lg-6">
            <div class="login d-flex align-items-center py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-lg-8 mx-auto">
                            @if ($errors->has('expired'))

                                <div class="alert alert-warning mt-3 alert-dismissible fade in" role="alert">
                                    <div>{{ $errors->first('expired') }}</div>

                                </div>

                            @endif
                            <h3 class="login-heading mb-4">Welcome to LeaseAccounting.app!</h3>
                            <form role="form" method="POST" action="{{ url('/login') }}">
                                @csrf
                                <div class="form-label-group">
                                    <input type="email" id="inputEmail" name="email" class="form-control"
                                           placeholder="Email address" value="{{$email}}" required autofocus>
                                    <label for="inputEmail">Email address</label>
                                    @if ($errors->has('email'))
                                        <span class="help-block text-danger pt-2 d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-label-group">
                                    <input type="password" id="inputPassword" class="form-control" name="password"
                                           placeholder="Password" required>
                                    <label for="inputPassword">Password</label>
                                    @if ($errors->has('password'))
                                        <span class="help-block text-danger pt-2 d-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" name="remember"
                                           id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Remember me?</label>

                                </div>
                                <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2"
                                        type="submit">Sign in
                                </button>
                                <div class="text-center">
                                    <a class="small" href="{{ url('/password/reset') }}">Forgot password?</a></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --input-padding-x: 1.5rem;
        --input-padding-y: 0.75rem;
    }

    .login,
    .image {
        min-height: 100vh;
    }

    .btn-primary {
        background-color: #1999E3 !important;
        opacity: .768;
    }

    .bg-image {
        background-image: url('/img/lg_bk.jpg');
        background-size: cover;
        background-position: center;
    }

    .login-heading {
        font-weight: 300;
    }

    .btn-login {
        font-size: 0.9rem;
        letter-spacing: 0.05rem;
        padding: 0.75rem 1rem;
        border-radius: 2rem;
    }

    .form-label-group {
        position: relative;
        margin-bottom: 1rem;
    }

    .form-label-group > input,
    .form-label-group > label {
        padding: var(--input-padding-y) var(--input-padding-x);
        height: auto;
        border-radius: 2rem;
    }

    .form-label-group > label {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 100%;
        margin-bottom: 0;
        /* Override default `<label>` margin */
        line-height: 1.5;
        color: #495057;
        cursor: text;
        /* Match the input under the label */
        border: 1px solid transparent;
        border-radius: .25rem;
        transition: all .1s ease-in-out;
    }

    .form-label-group input::-webkit-input-placeholder {
        color: transparent;
    }

    .form-label-group input:-ms-input-placeholder {
        color: transparent;
    }

    .form-label-group input::-ms-input-placeholder {
        color: transparent;
    }

    .form-label-group input::-moz-placeholder {
        color: transparent;
    }

    .form-label-group input::placeholder {
        color: transparent;
    }

    .form-label-group input:not(:placeholder-shown) {
        padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
        padding-bottom: calc(var(--input-padding-y) / 3);
    }

    .form-label-group input:not(:placeholder-shown) ~ label {
        padding-top: calc(var(--input-padding-y) / 3);
        padding-bottom: calc(var(--input-padding-y) / 3);
        font-size: 12px;
        color: #777;
    }

    /* Fallback for Edge
    -------------------------------------------------- */

    @supports (-ms-ime-align: auto) {
        .form-label-group > label {
            display: none;
        }

        .form-label-group input::-ms-input-placeholder {
            color: #777;
        }
    }

    /* Fallback for IE
    -------------------------------------------------- */

    @media all and (-ms-high-contrast: none),
    (-ms-high-contrast: active) {
        .form-label-group > label {
            display: none;
        }

        .form-label-group input:-ms-input-placeholder {
            color: #777;
        }
    }

</style>
<script src="/auth-assets/jquery.slim.min.js"></script>
<script src="/auth-assets/bootstrap.min.js"></script>
<script src="/auth-assets/bootstrap.bundle.min.js"></script>
</body>
</html>--}}


@extends('website.views.layouts.master')
@push('meta')
    <meta name="description" content="Lease managaement/accounting system for small business to enterprise.">
    <meta name="author" content="LeaseAccounting Ltd">
    <title>Login to LeaseAccounting.app</title>
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

@section('content')
    <section class="mt-3  h-100 mb-5 py-3 ">
        <div>
            <div class="container  d-flex justify-content-center align-items-center">
                <div class="row flex-center ">
                    <div class="col-md-12 mb-5">
                        <a href="{{route('landing_page')}}"><img src="/img/logo-blue.svg" alt="" class="srcimg" style="width:120px"></a>
                    </div>
                    <div class="col-md-12">
                        <div class="container">

                            <div class="row">
                                <div class="col-md-12 right_custom_registartion">
                                    <div>
                                        <h3>Login to your account</h3>
                                        <div class="sub">Enjoy LeaseAccounting.app</div>
                                    </div>
                                    <div class="text-center">
                                        Dont' have an account?
                                        <u class="text-primary"> <a class="" href="{{route('register')}}">Sign up</a></u>
                                    </div>

                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <div class="spark-screen container">
                                        <div>
                                            <div class="companY_information mt-4 pt-1">
                                                <form method="POST" action="{{ url('/login') }}">
                                                    {!! csrf_field() !!}

                                                    <div class="form-row mb-4">
                                                        <div class="col-md-12 ">
                                                            <label for="email" class="small  mb-1 active d-none">Email address</label>
                                                            <input type="email" id="email" name="email" class="form-control py-4" value="{{$email}}"  placeholder="Email address" required autofocus>
                                                            @if ($errors->has('email'))
                                                                <div class="span_holder position-relative">
                                                                        <span class="invalid-feedback ml-0">
                                                                            {{ $errors->first('email') }}
                                                                        </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-row mb-3">

                                                        <div class="col-md-12">
                                                            <label for="password" class="small  mb-1 active d-none">Password</label>
                                                            <input class="form-control py-4"   type="password" id="password"   name="password" placeholder="Password" required>
                                                            @if ($errors->has('password'))
                                                                <div class="span_holder position-relative">
                                                                        <span class="invalid-feedback ml-0">
                                                                            {{ $errors->first('password') }}
                                                                        </span>
                                                                </div>
                                                            @endif
                                                        </div>

                                                   </div>


                                                    <div class="form-row ">

                                                        <div class="col-md-6 d-flex">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" name="remember"
                                                                       id="customCheck1">
                                                                <label class="custom-control-label" for="customCheck1"><span class="remembar-me-span">Remember me?</span></label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 d-flex justify-content-end">
                                                            <div class="text-center">
                                                               <u class="text-primary"> <a class="small" href="{{ url('/password/reset') }}">Forgot password?</a></u>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 mt-4 pr-0 d-flex justify-content-end">
                                                            <button class="btn btn-light   btn-primary-variant-main  px-5 waves-effect waves-light" type="submit">
                                                                    <span>
                                                                        <i class="fa fa-btn fa-arrow-right"></i> Sign in
                                                                    </span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('header-scripts-area')
    <link rel="stylesheet" href="{{ mix('/css/website.css') }}">
    <style>
        .remembar-me-span{
            position: relative;
            top: 3px;
        }
    </style>
@endpush
@push('footer-scripts')

@endpush
@push('footer-scripts-top')
@endpush