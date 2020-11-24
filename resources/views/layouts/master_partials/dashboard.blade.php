<div id="content_height_fixer">
    <main id="main-content-area">

        <div class="container-fluid text-center">


            <!-- Necessary for Flash::overlay -->
            @include('flash::message')
            <script>$('#flash-overlay-modal').modal();</script>
            {!! Session::forget('flash_notification') !!}
            @yield('content')

        </div>

    </main>

</div>

