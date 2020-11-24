@extends('layouts.master')
@section('css')
    <style>
        .extension_heading {
            background-color: #36414E !important;
            color: #fff;
        }
    </style>
@stop
@section('javascript')
    <script src="{{ mix('/tenant/app.js') }}"></script>
    <script src="{{ mix('/js/custom/audit_trail.js') }}"></script>
    <script>
        $(document).ready(function () {
            var table = $('#leaseflow_display').dataTable({
                "aLengthMenu": [[10, 25, 50, 200, 500, -1], [10, 25, 50, 200, 500, "All"]],
                "iDisplayLength": -1,
                "ordering": false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: "csv",
                        title: 'LeaseFlow',
                        className: "btn-sm",
                        footer: true
                    },
                    {
                        extend: "excel",
                        title: 'LeaseFlow ',
                        className: "btn-sm",
                        footer: true
                    },
                    {
                        extend: "pdfHtml5",
                        orientation: 'landscape',
                        title: 'LeaseFlow',
                        className: "btn-sm",
                        pageSize: 'A3',
                        footer: true
                    },
                    {
                        extend: "pageLength",
                        className: "btn-sm"
                    }
                ]
            });
        });
    </script>
    <script>

        // For Multiselect
        $(document).ready(function() {
            $('.js-multiselect').select2({
                placeholder: "{{Lang::get('master.Select (Optional)')}}",
                closeOnSelect: false
            });
        });
        // For CCY
        $(document).ready(function() {
            $('.js-singleselect').select2({
                placeholder: "{{Lang::get('master.Select (Optional)')}}"
            });
        });
    </script>
    <script>

        jQuery(document).ready(function ($) {
            if (window.location.href.indexOf("create") > -1) {
                changeCurrency();
            }

            $('#currency_id').change(function () {
                changeCurrency();
            });

            $('#lease_amount').on('input', function (e) {
                var leaseAmount = $("#lease_amount").val();
                var serviceCost = $("#lease_service_cost").val();
                var total = (serviceCost.replace(/,/g, '') * 10 + leaseAmount.replace(/,/g, '') * 10);
                $("#total_lease").val(total / 10);
            });
            $('#lease_service_cost').on('input', function (e) {
                var serviceCost = $("#lease_service_cost").val();
                var leaseAmount = $("#lease_amount").val();
                var total = (serviceCost.replace(/,/g, '') * 10 + leaseAmount.replace(/,/g, '') * 10);
                $("#total_lease").val(total / 10);
            });
            $('#entity_id').change(function () {
                if ($(this).val()) {
                    $.get({url: '/dropdown/entity/lease'}, {entityId: $(this).val()},
                        function (data) {
                            if (data && data.ifrs_accounting === 1) {
                                $("#ifrs_accounting").prop("checked", true);
                                $("#lease_rate").val(data.lease_rate);
                            } else {
                                $("#lease_rate").val(0);
                            }
                        });
                }
                //changeCurrency();
            });
        });

        function changeCurrency() {
            $.get({url: '/dropdown/account'},
                {option: [$('#currency_id').val(), $('#entity_id').val()]},
                function (data) {
                    var account_id = $('#account_id');
                    account_id.empty();
                    $.each(data, function (index, element) {
                        account_id.append("<option value='" + element.id + "'>" + element.account_name + "</option>");
                    });
                }
            );
        }
    </script>
    <script>
        $(document).ready(function(){

            $('.cost_center_split_checkbox').each(function(i, obj) {
                if(!$(this).is(':checked')){
                    var dataId = 'percentage['+$(this).attr("data-id")+']';
                    $('input[name="'+dataId+'"]').val(0).prop("disabled", true);

                }
            });
            $(".cost_center_split_checkbox").on("click", function(){
                if(!$(this).is(':checked')){
                    var dataId = 'percentage['+$(this).attr("data-id")+']';
                    $('input[name="'+dataId+'"]').val(0).prop("disabled", true);
                }
                else if($(this).is(':checked')){
                    var dataId = 'percentage['+$(this).attr("data-id")+']';
                    $('input[name="'+dataId+'"]').prop("disabled", false);
                }

            });

            $("#cost_center_split").on("click", function(){
                if(!$(this).is(':checked')){
                    $("#cost-center-split-view-active").hide();
                    $('#cost_center_split_tab').hide();

                }
                else if($(this).is(':checked')){
                    $("#cost-center-split-view-active").show();
                    $('#cost_center_split_tab').show();
                    $('#cost_center_split_tab').tab('show')

                }

            });

            if($("#cost_center_split").is(':checked')){
                $('#cost_center_split_tab').show();
                $("#cost-center-split-view-active").show();  // checked
            }
            else{
                $('#cost_center_split_tab').hide();
                $("#cost-center-split-view-active").hide();  // unchecked
            }
        });
    </script>
    <script>
        jQuery(document).ready(function ($) {
           /* updateAmount();
            $('#extension_period_amount').on('input', function (e) {
                updateAmount();
            });
            $('#extension_service_cost').on('input', function (e) {
                updateAmount();
            });*/
            $('.lease_extension_type').click(function () {
                if ($('#increase_in_scope').is(':checked')) {
                    $("#decrease_in_scope_rate").prop('disabled', true);
                    $("#extension_end_date").prop('disabled', false);
                    $("#extension_start_date").prop('disabled', false);
                } else if ($('#decrease_in_scope').is(':checked')) {
                    $("#decrease_in_scope_rate").prop('disabled', false);
                    $("#extension_end_date").prop('disabled', false);
                    $("#extension_start_date").prop('disabled', false);
                } else if ($('#decrease_in_term').is(':checked')) {
                    $("#decrease_in_scope_rate").prop('disabled', true);
                    $("#extension_end_date").prop('disabled', false);
                    $("#extension_start_date").prop('disabled', false);
                } else if ($('#terminate_lease').is(':checked')) {
                    $("#decrease_in_scope_rate").prop('disabled', true);
                    $("#extension_end_date").prop('disabled', true).val('');
                    $("#extension_start_date").prop('disabled', true).val('');
                }
            });
        });

      /*  function updateAmount() {
            alert('i am here');
            var leaseAmount = $("#extension_period_amount").val();
            var serviceCost = $("#extension_service_cost").val();
            var total = (serviceCost.replace(/,/g, '') * 10 + leaseAmount.replace(/,/g, '') * 10);
            $("#extension_total_cost").val(total / 10);
        }*/
    </script>
@stop
@section('content')
    {!! Form::model($lease,['id'=>'lease-update-form' ,'method'=>'PATCH', 'route'=>['leases.update', $lease->id],
    'data-parsley-validate class'=>'form-horizontal form-label-left', 'files' => true]) !!}
    @include('Lease/leases/partials/_form',['addOrEditText'=>'Edit'])
    {!! Form::close() !!}
@stop
