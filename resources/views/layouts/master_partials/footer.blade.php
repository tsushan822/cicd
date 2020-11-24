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

            &nbsp;<a class=" text-dark" href="https://{{(config('zenlease.server_url'))}}/page/terms" target="_blank" rel="nofollow">Terms Of Service </a>&nbsp
            | &nbsp<a class=" text-dark" href="https://{{(config('zenlease.server_url'))}}/page/privacy-policy" target="_blank" rel="nofollow">Privacy Policy</a>
        </div>
    </div>
    <!-- Copyright -->

</footer>


<script type="text/javascript" src="/js/material/jquery-3.4.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="/js/material/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="/js/material/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="/js/material/mdb.min.js"></script>
<script src="{{ mix('/js/zentreasury.js') }}"></script>
<script src="{{ mix('/app/notification-components/app.js') }}"></script>
<script type="text/javascript" src="/js/vendor/datatables/datatable.min.js"></script>
<script>
    var allTranslation = "{!! __('master.All') !!}";
    $(document).ready(function () {
        var table = $.when($('#zentable_landscape').dataTable({
            "aLengthMenu": [[25, 50, 100, 200, 500, -1], [25, 50, 100, 200, 500, allTranslation]],
            "iDisplayLength": 50,
            "order": [] ,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: "copy",
                    className: "buttons-copy btn  btn-sm  btn-primary-variant-one  px-2 waves-effect  waves-effect "
                },
                {
                    extend: "csv",
                    className: "buttons-csvbtn  btn-sm  btn-primary-variant-one  px-2 waves-effect  waves-effect"
                },
                {
                    extend: "excel",
                    className: "buttons-excel btn  btn-sm  btn-primary-variant-one  px-2 waves-effect  waves-effect"
                },
                {
                    extend: "print",
                    className: "buttons-print btn  btn-sm  btn-primary-variant-one  px-2 waves-effect  waves-effect"
                }
            ],
            stateSave: true,
        })).then(function(){
            $('.dt-button').addClass( "btn  waves-effect btn-sm").removeClass( "dt-button buttons-html5" );
            $('input[type=search]').addClass('form-control border-0 bg-light');
        });
    });
    $(document).ready(function () {
        var table = $('#report').dataTable({
            "oLanguage": {
                "sUrl": "/languages/dataTables.<?php if(isset(Auth ::user() -> locale)) {
                    echo Auth ::user() -> locale;
                }?>.txt"
            },
            "aLengthMenu": [[25, 50, 100, 200, 500, -1], [25, 50, 100, 200, 500, allTranslation]],
            "iDisplayLength": 25,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: "copy",
                    className: "btn  waves-effect btn-sm"
                },
                {
                    extend: "csv",
                    className: "btn  waves-effect btn-sm"
                },
                {
                    extend: "excel",
                    className: "btn  waves-effect btn-sm"
                },
                {
                    extend: "print",
                    className: "btn  waves-effect btn-sm"
                }
            ],
            stateSave: true,
        });
    });
</script>
<script src="{{ mix('/js/zentreasury-form.js') }}"></script>
<script src="{{ mix('/js/vendor/jquery-ui.min.js') }}"></script>
<script src="{{ mix('/js/custom/deals.js') }}"></script>
@yield('javascript')
{{--to get datepicker language--}}
<script type="text/javascript">
    $.datepicker.setDefaults($.datepicker.regional['<?php if(isset(Auth ::user() -> locale)) {
        echo Auth ::user() -> locale;
    }?>']);
</script>
<script>
    window.onbeforeunload = function () {
        if(document.getElementById("loader_loading")){
            document.getElementById("loader_loading").style.display = "block";
        }
    };
    $('form').submit(function() {
        $('#register_submit').prop("disabled", "disabled");
    })
</script>
<script>$('#flash-overlay-modal').modal();</script>
{{--Scroll to top--}}
@stack('vue-scripts')
@if(env('APP_ENV') != 'testing')
<script>
    $(document).ready(function() {
        $('.mdb-select').materialSelect();
        $('.toast').toast('show');
        //$('.mdb-select.select-wrapper .select-dropdown').removeAttr('readonly').prop('required', true).addClass('form-control').css('background-color', '#fff');
        $('.mdbCv').find(".mdb-select.select-wrapper .select-dropdown").val("").removeAttr('readonly').attr("placeholder",
            "Select Item").prop('required', true).addClass('form-control').css('background-color', '#fff');
        $('.mdbCpv').find(".mdb-select.select-wrapper .select-dropdown").removeAttr('readonly').prop('required', true).addClass('form-control').css('background-color', '#fff');
        $('.mdbIv').find('input').prop('required',true);
        $('.datepickerm').pickadate({
            format: 'yyyy-mm-dd',
        });
        $('.datepicker').removeAttr('readonly');
    });
</script>
@else
<style>
    select.mdb-select {
        display: block !important;
    }
</style>
<script>
    $(document).ready(function() {
        //$('.mdb-select').materialSelect();
        $('.toast').toast('show');
        //$('.mdb-select.select-wrapper .select-dropdown').removeAttr('readonly').prop('required', true).addClass('form-control').css('background-color', '#fff');
        $('.mdbCv').find(".mdb-select.select-wrapper .select-dropdown").val("").removeAttr('readonly').attr("placeholder",
            "Select Item").prop('required', true).addClass('form-control').css('background-color', '#fff');
        $('.mdbCpv').find(".mdb-select.select-wrapper .select-dropdown").removeAttr('readonly').prop('required', true).addClass('form-control').css('background-color', '#fff');
        $('.mdbIv').find('input').prop('required',true);
        $('.datepickerm').pickadate({
            format: 'yyyy-mm-dd',
        });
        $('.datepicker').removeAttr('readonly');
    });
</script>
@endif
<script>
    $(document).ready(function() {
        (function () {
            'use strict';
            window.addEventListener('load', function () {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                            $('#form-error-alert').show();
                        }
                        form.classList.add('was-validated');
                        $('#register_submit').prop('disabled', false);
                        if (form.checkValidity() !== false){
                            $('#form-error-alert').hide()
                        }
                    }, false);
                });
            }, false);
        })();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        var elementList = document.getElementsByTagName('label');
        for(var i = 0; i < elementList.length; i++)
        {
            elementList[i].classList.add('active');
        }
    });
</script>
@stack('additional-css')
@stack('form-js')
</body>
</html>