<!DOCTYPE html>
<html lang="en" class="full-height">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" id="csrf-token" content="{{csrf_token()}}">
    @stack('meta')
    @include('sub-views.favicon')
    @yield('css')
    <link rel="stylesheet" href="{{ mix('/css/zentreasury.css') }}">
    @stack('header-scripts-area')
    <style>
        .text-black-50-custom{
            color: rgb(0 0 0 / 87%) !important;
        }
        .h3-title{
            margin-top: 10px;
            font-family: "Nunito-Medium", sans-serif !important;
            font-weight: 300;
            font-size: 1.75rem;
            line-height: 1.2;
        }
        .h5-title{
            font-family: "Nunito-Medium", sans-serif !important;
            font-weight: 300;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            line-height: 1.2;
            margin-top: 0;
        }
    </style>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8407X6E4VE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-8407X6E4VE');
    </script>
</head>