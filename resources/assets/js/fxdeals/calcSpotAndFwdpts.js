/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//Calculate spot+pts=forward rate 
$(document).ready(function () {
    function compute() {
        var a = $('#spot_rate').val();
        $('#swap_spot_rate').val(a).change();
        let swap_forward_point = $('#swap_forward_point').val();
        $('#swap_forward_rate').val(a + swap_forward_point);
        var b = $('#forward_point').val();
        var total = ((+a * 10) + (+b * 10)) / 10;
        $('#forward_rate').val(total);

    }

    function swapCompute() {
        /*For swap*/
        var swapSpotRate = $('#swap_spot_rate').val();
        var swapForwardPoint = $('#swap_forward_point').val();
        var total = ((+swapSpotRate * 10) + (+swapForwardPoint * 10)) / 10;
        $('#swap_forward_rate').val(total).change();
    }

    $('#spot_rate').change(compute);
    $('#forward_point').change(compute);
    $('#swap_spot_rate').change(swapCompute);
    $('#swap_forward_point').change(swapCompute);
});