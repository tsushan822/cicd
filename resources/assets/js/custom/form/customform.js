/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//jquery.inputmask for numbers

$(".decimal").inputmask({
    'alias': 'decimal',
    'groupSeparator': ',',
    'autoGroup': true,
    'digits': 6,
    'digitsOptional': false,
    'placeholder': '0.000000',
    rightAlign: false,
    clearMaskOnLostFocus: !1
});

$(".decimal10").inputmask({
    'alias': 'decimal',
    'groupSeparator': ',',
    'autoGroup': true,
    'digitsOptional': true,
    'digits': 8,
    'placeholder': '0.000000[0000]',
    greedy: false,
    rightAlign: false,
    clearMaskOnLostFocus: !1
});

//jquery.inputmask for currency

$(".currency").inputmask('currency', {
    radixPoint: '.', prefix: "",
    rightAlign: false
});

$(".currencyNonNegative").inputmask('currency', {
    radixPoint: '.', prefix: "",
    rightAlign: false,
    allowMinus: false
});

//jquery.inputmask for dates
$(".date").inputmask({
    mask: "y-1-2",
    placeholder: "yyyy-mm-dd",
    leapday: "-02-29",
    separator: "-",
    alias: "yyyy/mm/dd"
});
