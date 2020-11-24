<footer class="footer_area pl-0 page-footer footer_area font-small bg-white footer-icons-area-holder">

    <!-- Footer Elements -->
    <div class="container">

        <!-- Grid row-->
        <div class="row">

            <!-- Grid column -->
            <div class="col-md-12 py-4">
                <div class="mb-5 flex-center">

                    <a class="fb-ic" href="https://www.facebook.com/LeaseAccountingapp-112807300630185" target="_blank">
                        <i class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <a class="ins-ic" href="https://www.instagram.com/leaseaccounting.app/?hl=en" target="_blank">
                        <i class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <a class="li-ic" href="https://www.youtube.com/channel/UCC1kJ8-b6rcz02Oqlaj6vAQ" target="_blank">
                        <i class="fab fa-youtube fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <a class="li-ic" href="https://www.linkedin.com/showcase/leaseaccounting-app/" target="_blank">
                        <i class="fab fa-linkedin-in fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                </div>
            </div>
            <!-- Grid column -->

        </div>
        <!-- Grid row-->

    </div>
    <!-- Footer Elements -->

    <!-- Copyright -->
    <div class="footer-copyright border-top bg-white text-dark text-center py-3 d-flex flex-wrap-reverse justify-content-center">
        <div class="mr-md-5 copyright_area_footer">
            © LeaseAccounting.app 2020
        </div>
        <div>

            &nbsp;<a class=" text-dark" href="/page/terms" target="_blank">Terms Of Service </a>&#xA0;
            | &#xA0;<a class=" text-dark" href="/page/privacy-policy" target="_blank">Privacy Policy</a>
        </div>
    </div>
    <!-- Copyright -->

</footer>
@include('cookieConsent::index')

<!-- Footer -->
@stack('footer-scripts-top')

<!-- JQuery -->


<script src="{{ mix('/app/website-components/nav-toggler.js') }}"></script>

@stack('footer-scripts')

