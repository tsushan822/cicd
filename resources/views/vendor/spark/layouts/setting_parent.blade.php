<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <style>
        body {
            overflow-x: hidden;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            -webkit-transition: margin .25s ease-out;
            -moz-transition: margin .25s ease-out;
            -o-transition: margin .25s ease-out;
            transition: margin .25s ease-out;
            background: #028CDE;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
            display: flex;
            margin-left: 0.5rem;
        }

        #sidebar-wrapper .list-group {
            width: 15rem;
            margin-top: 20px;
        }

        #page-content-wrapper {
            min-width: 100vw;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }
        .img-logo{
            width: 100px;
        }
        .list-group-lease-accounting-subscription{

        }
        .list-group-lease-accounting-subscription a{
            margin-bottom: 20px;
            color:#fff !important;
        }
        .list-group-item.active{
            border:unset !important;
            background: #0B7EC3 !important;
            z-index:1 !important;
        }
        .list-group-lease-accounting-subscription .active:before{
            border-right: 17px solid #ddd;
            border-top: 17px solid transparent;
            border-bottom: 17px solid transparent;
            content: "";
            display: inline-block;
            position: absolute;
            right: 0;
            top: 8px;
        }
        .list-group-lease-accounting-subscription .active:after{
            border-right: 17px solid #f4f3ef;
            border-top: 17px solid transparent;
            border-bottom: 17px solid transparent;
            content: "";
            display: inline-block;
            position: absolute;
            right: -1px;
            top: 8px;
            border-right-color: #f6f9fc;
        }
        .list-group-lease-accounting-subscription a{
            background-color: transparent;
        }
        .list-group-lease-accounting-subscription a:hover{
            background-color: transparent;
            border: unset;
            color: #f5f5f5;
        }
        .unsetDefaulBgAndBorder{
            background-color: transparent;
            border:unset !important;
        }
        .list-group-lease-accounting-subscription i{
            font-size: 24px;
            float: left;
            margin-right: 15px;
            line-height: 30px;
            width: 30px;
            text-align: center;
            position: relative;
            top: -3px;
        }
        .card {
            border-radius: 6px !important;
            -webkit-box-shadow: 0 2px 2px rgba(204,197,185,.5) !important;
            box-shadow: 0 2px 2px rgba(204,197,185,.5) !important;
            background-color: #fff !important;
            color: #252422 !important;
            margin-bottom: 20px !important;
            position: relative !important;
            z-index: 1 !important;
        }
        .btn-primary, .btn-default {
            display: inline-block;
            color: #13B5EA !important;
            font-weight: 500;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: #fff !important;
            border: 1px solid transparent !important;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12) !important;
            margin-left: 0rem !important;
            margin-right: 0rem !important;
            padding: 0.5rem 1.6rem;
            font-size: 13px !important;
            width: 155px;
        }
        .btn-primary:hover{
            color: #13B5EA !important;
            background-color: #fff !important;
            font-size:13px !important;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.18), 0 4px 15px 0 rgba(0, 0, 0, 0.15) !important;
            width: 155px;
        }

        .pricing .card {
            border: none;
            border-radius: 1rem;
            transition: all 0.2s;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }

        .pricing hr {
            margin: 1.5rem 0;
        }

        .pricing .card-title {
            display: inline-block;
            border-radius: 15px;
            background-color: #f5f4ff;
            color: #028CDE !important;
            padding: 5px 15px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .pricing .card-price {
            font-size: 3rem;
            margin: 0;
            display:flex;
        }

        .pricing .card-price .period {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            margin-top: 17px;

        }

        .pricing ul li {
            margin-bottom: 1rem;
        }
        .form_type_selected,.form_type:hover {
            background: #1999E3;
            border: 1px solid;
            color: white;
            cursor: pointer;
            -webkit-transition: .3s;
            transition: .3s;
        }
        .form_type {
            width: 100%;
            text-align: center;
            padding: 20px 10px;
            border: 1px dotted;
        }
        .list-group-item-add-on{
            position: relative;
            display: block;
            padding: 0.75rem 0rem;
            background-color: unset;
            border: unset;
        }
        .lease_number{
            margin: 1rem 0rem;
        }
        .lease_number>h5{
            margin-bottom:0;
        }
        .modal-backdrop{
            display:none !important;
        }
        .pricing_estimate h5 {
            font-weight: 700;
            display: flex;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 2.5rem;
        }
        .text_right small, .footer_text small{
            color: #516f90!important;
        }
        .text_left  h6{
            display:flex;
            align-items:center;
        }
        .cost_breakdown_background{
            background-color: rgb(245, 248, 250);
        }
        .compare_plan_button_modal_area{
            display: flex;
            justify-content: center;
            padding: 1rem 0rem;
            margin-bottom: 0;
            border: 2px solid red;
        }
        .compare_plan_button_modal_area span{
            margin-top: 6px;
            margin-right: 5px;
        }
        .compare_plan_button_modal_area button{
            background: #008cde;
            color: white;
        }
        .compare_plan_button_modal_area button:hover{
            background: #008cde;
            color: white;
        }
        .custom_loader_card{
            height:500px
        }
        .custom_loader_card .spinner-border{
            width: 4rem;
            height: 4rem;
        }
    </style>
    <!-- CSS -->
    <link href="{{ mix(Spark::usesRightToLeftTheme() ? 'css/app-rtl.css' : 'css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @stack('scripts')

    <!-- Global Spark Object -->
    <script>
        window.Spark = <?php echo json_encode(array_merge(Spark::scriptVariables(), [])); ?>;
    </script>

    {{--Favicon--}}
    @include('sub-views.favicon')
</head>
<body>
    <div id="spark-app" v-cloak>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div  id="sidebar-wrapper">
                <div class="sidebar-heading"><a href="/"><img src="/img/logo.svg" class="img-logo" alt="LeaseAccounting.app"></a></div>
                <div class="list-group list-group-flush list-group-lease-accounting-subscription">

                    <a href="/main" class="list-group-item unsetDefaulBgAndBorder text-transform-uppercase list-group-item-action"><i class="fa fa-arrow-left"></i>{{trans('master.Main Application')}}</a>
                    <a href="#subscription" aria-controls="subscription" role="tab" data-toggle="tab" class="active list-group-item unsetDefaulBgAndBorder  list-group-item-action "><i aria-hidden="true" class="fa fa-fw fa-btn fa-shopping-bag"></i>{{trans('master.Subscription')}}</a>
                    <a href="#payment-method" aria-controls="payment-method" role="tab" data-toggle="tab" class="list-group-item unsetDefaulBgAndBorder  list-group-item-action "><i aria-hidden="true" class="fa fa-fw fa-btn fa-credit-card"></i>{{trans('master.Update Billing Data')}}</a>
                    <a  href="#invoices" aria-controls="invoices" role="tab" data-toggle="tab" class="list-group-item unsetDefaulBgAndBorder  list-group-item-action "><i aria-hidden="true" class="fa fa-fw fa-btn fa-history"></i>{{trans('master.Invoices')}}</a>

                </div>
            </div>
            <!-- /#sidebar-wrapper -->
            <!-- Page Content -->
            <div id="page-content-wrapper">

                @if (Auth::check())
                    @include('spark::nav.user')
                @else
                    @include('spark::nav.guest')
                @endif

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <!-- /#page-content-wrapper -->

        </div>
        <!-- Application Level Modals -->
        @if (Auth::check())
            @include('spark::modals.notifications')
            @include('spark::modals.support')
            @include('spark::modals.session-expired')
        @endif
    </div>

    <!-- JavaScript -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('/js/sweetalert.min.js') }}"></script>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
@stack('additional-css-spark')
</body>
</html>
