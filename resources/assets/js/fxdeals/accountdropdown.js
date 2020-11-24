/*$(document).ready(function () {
    $('#spot_rate, #forward_point, #notional_currency_amount').on("change", function () {
        var spot_rate = +$("#spot_rate").val();
        var forward_rate = spot_rate + +$("#forward_point").val();
        $("#forward_rate").val(forward_rate);
        var notional_currency_amount = +$("#notional_currency_amount").val();
        $("#cross_currency_amount").val(forward_rate * notional_currency_amount);
    });
});*/

jQuery(document).ready(function ($) {
    if (window.location.href.indexOf("create") > -1) {
        updateNotional.call(this);
        updateCross.call(this);
    }

    $('#notional_currency_id').change(function () {
        updateNotional.call(this);
    });

    $('#cross_currency_id').change(function () {
        updateCross.call(this);
    });
});

function changeCurrency(account_id, data) {
    $.get({url: '/dropdown/account'},
        {option: data},
        function (data) {
            account_id.empty();
            $.each(data, function (index, element) {
                account_id.append("<option value='" + element.id + "'>" + element.account_name + "</option>");
            });
        });
}

function updateNotional() {
    var account_id = $('#notional_account_id');
    var swap_account_id = $('#swap_notional_account_id');
    var data = [$('#notional_currency_id').val(), $('#entity_id').val()];
    changeCurrency(account_id, data);
    changeCurrency(swap_account_id, data);
    var selected = $(this).val();
    $('#swap_notional_currency_id').val(selected);
}

function updateCross() {

    var account_id = $('#cross_account_id');
    var swap_account_id = $('#swap_cross_account_id');
    var data = [$('#cross_currency_id').val(), $('#entity_id').val()];
    changeCurrency(account_id, data);
    changeCurrency(swap_account_id, data);
    var selected = $(this).val();
    $('#swap_cross_currency_id').val(selected);
}
