/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//Calculate cross_currency_amount 
$(document).ready(function () {
    $('#indirect').change(compute);
    $('#notional_currency_amount').change(function () {
        var a = $(this).val();
        a = a.replace(/\,/g, '');
        a = parseFloat(a);
        if ($('#buy_nominal').val() == 0) {
            a = (-1) * Math.abs(a);
            $(this).val(a);
        }
        compute();
    });
    $('#forward_point').change(compute);
    $('#spot_rate').change(compute);
    $('#swap_forward_rate').change(swapCompute);
    $('#swap_notional_currency_amount').change(swapCompute);
});

function compute() {
    var a = $('#notional_currency_amount').val();
    insertSwapAmount();
    a = a.replace(/\,/g, '');
    a = parseFloat(a);
    var b = $('#forward_rate').val();
    var total = calculateAmount(a, b);
    $('#cross_currency_amount').val(total);
}

function insertSwapAmount() {
    let aFloat = calculateOpposite();
    $('#swap_notional_currency_amount').val(aFloat).change();
}

function swapCompute() {
    var a = $('#swap_notional_currency_amount').val();
    a = a.replace(/\,/g, '');
    a = parseFloat(a);
    var b = $('#swap_forward_rate').val();
    var total = calculateAmount(a, b);
    $('#swap_cross_currency_amount').val(total);
}

function calculateAmount(a, b) {
    var sell_cross = $('#sell_cross').val();
    if ($('#indirect').prop('checked') === true) {
        var total = ((-1 * ((+a * 10) / (+b * 10)) / 10) * 10).toFixed(2);
    } else {
        var total = ((-1 * ((+a * 10) * (+b * 10)) / 10) / 10).toFixed(2);
    }
    if (sell_cross === 0)
        total = total * -1;
    if (sell_cross === 1)
        total = abs(total);

    return total;
}


//Change dropdown base on another dropdown BUY/SELL
$("#buy_nominal").change(function () {
    $("#swap_buy_nominal").val($("#sell_cross").val()).change();
    $("#sell_cross").val($(this).val());

    let aFloat = calculateOpposite();
    $('#notional_currency_amount').val(aFloat).change();
});

//Change dropdown base on another dropdown BUY/SELL
$("#sell_cross").change(function () {
    $("#swap_sell_cross").val($("#buy_nominal").val()).change();
    $("#buy_nominal").val($(this).val());

    let aFloat = calculateOpposite();
    $('#notional_currency_amount').val(aFloat).change();
});

//Change dropdown base on another dropdown BUY/SELL
$("#swap_buy_nominal").change(function () {
    $("#swap_sell_cross").val($(this).val());
});

//Change dropdown base on another dropdown BUY/SELL
$("#swap_sell_cross").change(function () {
    $("#swap_buy_nominal").val($(this).val());
});

function calculateOpposite() {
    let a = $('#notional_currency_amount').val();
    a = a.replace(/\,/g, '');
    let aFloat = parseFloat(a);
    aFloat = (-1) * aFloat;
    return aFloat;
}