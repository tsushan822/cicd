<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="robots" content="noindex">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="TMS Treasury Management System">
    <meta name="author" content="LeaseAccounting.app">
    <meta name="csrf-token" id="csrf-token" content="{{csrf_token()}}">


       <!-- Title -->
       <title>LeaseAccounting.app | TMS</title>

       <!-- Font Awesome -->
       <link href="/css/vendor/font-awesome.css" rel="stylesheet">

       <!-- Zentreasury -->
       <link rel="stylesheet" href="{{ mix('/css/zentreasury.css') }}">

       <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/img/favicon/apple-touch-icon-57x57.png"/>
       <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/img/favicon/apple-touch-icon-114x114.png"/>
       <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/img/favicon/apple-touch-icon-72x72.png"/>
       <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/img/favicon/apple-touch-icon-144x144.png"/>
       <link rel="apple-touch-icon-precomposed" sizes="60x60" href="/img/favicon/apple-touch-icon-60x60.png"/>
       <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/img/favicon/apple-touch-icon-120x120.png"/>
       <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/img/favicon/apple-touch-icon-76x76.png"/>
       <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/img/favicon/apple-touch-icon-152x152.png"/>
       <link rel="icon" type="image/png" href="/img/favicon/favicon-196x196.png" sizes="196x196"/>
       <link rel="icon" type="image/png" href="/img/favicon/favicon-96x96.png" sizes="96x96"/>
       <link rel="icon" type="image/png" href="/img/favicon/favicon-32x32.png" sizes="32x32"/>
       <link rel="icon" type="image/png" href="/img/favicon/favicon-16x16.png" sizes="16x16"/>
       <link rel="icon" type="image/png" href="/img/favicon/favicon-128.png" sizes="128x128"/>
       <meta name="application-name" content="&nbsp;"/>
       <meta name="msapplication-TileColor" content="#FFFFFF"/>
       <meta name="msapplication-TileImage" content="mstile-144x144.png"/>
       <meta name="msapplication-square70x70logo" content="mstile-70x70.png"/>
       <meta name="msapplication-square150x150logo" content="mstile-150x150.png"/>
       <meta name="msapplication-wide310x150logo" content="mstile-310x150.png"/>
       <meta name="msapplication-square310x310logo" content="mstile-310x310.png"/>

       <!-- Bootstrap -->
       <script src="/app/js/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
       <style>
           /*
      * Specific styles of signin component
      */
           /*
            * General styles
            */

           @media only screen and (min-width: 768px) {
               body {
                   background: radial-gradient(49% 124%, #fefeff 55%, #F5F2FA 100%) !important;
               }

               .card {

                   -moz-border-radius: 2px;
                   -webkit-border-radius: 2px;
                   border-radius: 2px;
                   -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                   -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                   box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
               }

               .card-container.card {
                   max-width: 350px;

               }
           }

           body, html {
               height: 100%;
               background-color: #F5F2FA;
           }

           .card-container.card {

               padding: 40px 40px;
           }

           .btn {
               font-weight: 700;
               height: 36px;
               -moz-user-select: none;
               -webkit-user-select: none;
               user-select: none;
               cursor: default;
               background-color: #1999e3 !important;
           }

           /*
            * Card component
            */
           .card {
               background-color: #F5F2FA;
               /* just in case there no content*/
               padding: 20px 25px 30px;
               margin: 0 auto 25px;
               margin-top: 50px;

           }

           .logo {
               width: 260px;
               height: 100px;
               margin-left: auto;
               margin-right: auto;
           }

           /*
            * Form styles
            */
           .profile-name-card {
               font-size: 16px;
               font-weight: bold;
               text-align: center;
               margin: 10px 0 0;
               min-height: 1em;
           }

           .reauth-email {
               display: block;
               color: #404040;
               line-height: 2;
               margin-bottom: 10px;
               font-size: 14px;
               text-align: center;
               overflow: hidden;
               text-overflow: ellipsis;
               white-space: nowrap;
               -moz-box-sizing: border-box;
               -webkit-box-sizing: border-box;
               box-sizing: border-box;
           }

           .form-signin #inputEmail,
           .form-signin #inputPassword {
               direction: ltr;
               height: 44px;
               font-size: 16px;
           }

           .form-signin input[type=email],
           .form-signin input[type=password],
           .form-signin input[type=text],
           .form-signin button {
               width: 100%;
               display: block;
               margin-bottom: 10px;
               z-index: 1;
               position: relative;
               -moz-box-sizing: border-box;
               -webkit-box-sizing: border-box;
               box-sizing: border-box;
           }

           .form-signin .form-control:focus {
               border-color: rgb(104, 145, 162);
               outline: 0;
               -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgb(104, 145, 162);
               box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgb(104, 145, 162);
           }

           .btn.btn-signin {
               /*background-color: #4d90fe; */
               background-color: rgb(104, 145, 162);
               /* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
               padding: 0px;
               font-weight: 700;
               font-size: 14px;
               height: 36px;
               -moz-border-radius: 3px;
               -webkit-border-radius: 3px;
               border-radius: 3px;
               border: none;
               -o-transition: all 0.218s;
               -moz-transition: all 0.218s;
               -webkit-transition: all 0.218s;
               transition: all 0.218s;
           }

           .btn.btn-signin:hover,
           .btn.btn-signin:active,
           .btn.btn-signin:focus {
               background-color: rgb(12, 97, 33);
           }

           .forgot-password {
               color: rgb(104, 145, 162);
           }

           .forgot-password:hover,
           .forgot-password:active,
           .forgot-password:focus {
               color: rgb(12, 97, 33);

           }

           .radio input[type="radio"], .radio-inline input[type="radio"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"], input[type="radio"], input[type="checkbox"] {
               -ms-transform: scale(1);
               -moz-transform: scale(1);
               -webkit-transform: scale(1);
               -o-transform: scale(1);
           }

           .checkbox {
               padding-left: 0px;

           }

           .btn.btn-signin {
               margin-top: 10px;
           }
       </style>

    <script src="/app/js/vendors/jquery/dist/jquery.min.js"></script>
        <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192" href="/img/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="/img/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
</head>
<body>
<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
    {!! csrf_field() !!}

    <div class="container">
        <div class="card card-container">

            @if ($errors->has('expired'))

                <div class="alert alert-warning mt-3 alert-dismissible fade in" role="alert">
                    <div>{{ $errors->first('expired') }}</div>

                </div>

        @endif


        <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="logo" src="/img/logo.svg"/>
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin">
                <span id="reauth-email" class="reauth-email"></span>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" id="inputEmail" placeholder="Email address" required="" class="form-control"
                           name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block text-danger pt-2 d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required=""
                           name="password">

                    @if ($errors->has('password'))
                        <span class="help-block text-danger pt-2 d-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
                <div id="remember" class="checkbox checkbox-primary">

                    <input type="checkbox" name="remember" value="remember-me" id="remember-me">
                    <label for="remember-me">Remember me</label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
            </form><!-- /form -->
            <a href="{{ url('/password/reset') }}" class="forgot-password">
                Forgot the password ?
            </a>
        </div><!-- /card-container -->
    </div><!-- /container -->

</form>

</body>
</html>