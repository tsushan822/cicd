/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * yy-mm-dd
 */


/*$('.datepicker').datepicker({
    dateFormat: 'yy-mm-dd', changeMonth: true,
    changeYear: true, yearRange: "-20:+50",
    firstDay: 1
});
$('.datepicker_weekends_included').datepicker({
    dateFormat: 'yy-mm-dd', firstDay: 1
});*/


$('.datepicker').datepicker({
    dateFormat: 'yy-mm-dd', changeMonth: true,
    changeYear: true, yearRange: "-20:+50",
    firstDay: 1
});
$('.datepicker_weekends_included').datepicker({
    dateFormat: 'yy-mm-dd', firstDay: 1
});


$.datepicker.regional['fi'] = {
    closeText: "Sulje",
    prevText: "&#xAB;Edellinen",
    nextText: "Seuraava&#xBB;",
    currentText: "Tänään",
    monthNames: [ "Tammikuu","Helmikuu","Maaliskuu","Huhtikuu","Toukokuu","Kesäkuu",
        "Heinäkuu","Elokuu","Syyskuu","Lokakuu","Marraskuu","Joulukuu" ],
    monthNamesShort: [ "Tammi","Helmi","Maalis","Huhti","Touko","Kesä",
        "Heinä","Elo","Syys","Loka","Marras","Joulu" ],
    dayNamesShort: [ "Su","Ma","Ti","Ke","To","Pe","La" ],
    dayNames: [ "Sunnuntai","Maanantai","Tiistai","Keskiviikko","Torstai","Perjantai","Lauantai" ],
    dayNamesMin: [ "Su","Ma","Ti","Ke","To","Pe","La" ],
    weekHeader: "Vk",
    dateFormat: "d.m.yy",
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ""
};

$.datepicker.regional['en'] = {
    closeText: "Done",
    prevText: "Prev",
    nextText: "Next",
    currentText: "Today",
    monthNames: [ "January","February","March","April","May","June",
        "July","August","September","October","November","December" ],
    monthNamesShort: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
    dayNames: [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ],
    dayNamesShort: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
    dayNamesMin: [ "Su","Mo","Tu","We","Th","Fr","Sa" ],
    weekHeader: "Wk",
    dateFormat: "dd/mm/yy",
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: "" };

$.datepicker.regional['sv'] = {
    closeText: "Stäng",
    prevText: "&#xAB;Förra",
    nextText: "Nästa&#xBB;",
    currentText: "Idag",
    monthNames: [ "januari","februari","mars","april","maj","juni",
        "juli","augusti","september","oktober","november","december" ],
    monthNamesShort: [ "jan.","feb.","mars","apr.","maj","juni",
        "juli","aug.","sep.","okt.","nov.","dec." ],
    dayNamesShort: [ "sön","mån","tis","ons","tor","fre","lör" ],
    dayNames: [ "söndag","måndag","tisdag","onsdag","torsdag","fredag","lördag" ],
    dayNamesMin: [ "sö","må","ti","on","to","fr","lö" ],
    weekHeader: "Ve",
    dateFormat: "yy-mm-dd",
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: "" };


/*   https://github.com/jquery/jquery-ui/tree/master/ui/i18n */

