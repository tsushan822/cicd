@include('website.views.layouts.header')
<body id="page-top" class="fixed-sn white-skin">
<div class="container-fluid text-center pl-0 pr-0 ml-0 mr-0">
@include('website.views.layouts.sidebar')
<!-- Main content -->
@yield('content')
</div>
@include('website.views.layouts.footer')
<!-- Main content -->
@stack('additional-footer-js')
</body>

</html>



