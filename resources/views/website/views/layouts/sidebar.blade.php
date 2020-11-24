<!-- Navigation -->
<div class="header_ui_background fixed-top">
    <div class="header_ui_area">
        <div class="top_header ">
            <div class="top_header_left">
                <a href="/"><img src="../img/logo.svg" alt="LeaseAccounting logo" class="srcimg logo-img-styling"><span></span></a>
            </div>
            <div class="module_link_area d-flex align-items-center">
            </div>
            <div class="module_link_area top_header_right d-flex align-items-center">
                <ul class="nav smooth-scroll md-pills ">
                    <li class="nav-item ">
                        <a class="nav-link" href="/pricing" >Pricing</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="/blog" >Blog</a>
                    </li>
                </ul>
                <a class="free-trial-button-nav-top pr-3 pl-3 mr-1 btn-primary-variant-one  waves-effect waves-light" href="{{route('login_initial')}}">LOGIN</a>
                <a class="free-trial-button-nav-top  btn-primary-variant-one  waves-effect waves-light" href="/register">FREE TRIAL</a>
            </div>
        </div>
        <nav class="navbar  navbar-dark bg-dark d-none boxShadowRemoval navbar-la-mobile">
            <a href="/" class="navbar-brand"><img src="/img/logo.svg" alt="LeaseAccounting logo" class="src logo-img-styling"></a>
            <button id="navbarTogglerClickArea" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"  aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbarTogglerVisibleArea" class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                        <a class="nav-link waves-effect waves-light" href="/pricing" >Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link waves-effect waves-light" href="/blog" >Blog</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link waves-effect waves-light" href="/register" >Free Trial</a>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light" href="{{route('login_initial')}}">Login</a>
                        </li>

                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- Navigation end -->
