$(document).ready(function () {
    var preview = $('#previewTable');
    $('#audittrail-tab').one("click", function () {
        preview.hide();
        $('#loading-message').show();
        fetchRecords(preview);
    });

});

function fetchRecords(preview) {
    var id = $('#model_id').val();
    var model = $('#model').val();
    var tbody = $('#ajax-tbody');
    $.ajax({
        url: '/audit-trail/' + model + '/' + id,
        type: 'get',
        dataType: 'json',
        success: function success(response) {
            $('#audit_taril_apinner').hide();
            preview.show();
            var html = '';
            $.each(response, function (i) {
                html += '<tr><td>' + response[i].user + '</td><td>' + response[i].event + '</td><td>' + response[i].title + '</td><td>' + response[i].before + '</td><td>' + response[i].after + '</td><td>' + response[i].diff_for_humans + '</td><td>' + response[i].date_time + '</td><td>' + response[i].time_zone;
            });
            tbody.html(html);

            showDataTable();

        }
    });
}

function showDataTable() {
    $.when($('#previewTable').dataTable({
        "aLengthMenu": [[25, 50, 100, 200, 500, -1], [25, 50, 100, 200, 500, allTranslation]],
        "iDisplayLength": 50,
        "order": [] ,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: "copy",
                className: "buttons-copy btn  btn-sm  btn-primary  px-2 waves-effect  waves-effect "
            },
            {
                extend: "csv",
                className: "buttons-csvbtn  btn-sm  btn-primary  px-2 waves-effect  waves-effect"
            },
            {
                extend: "excel",
                className: "buttons-excel btn  btn-sm  btn-primary  px-2 waves-effect  waves-effect"
            },
            {
                extend: "print",
                className: "buttons-print btn  btn-sm  btn-primary  px-2 waves-effect  waves-effect"
            }
        ],
        stateSave: true,
    })).then(function(){
        $('.dt-button').addClass( "btn  waves-effect btn-sm").removeClass( "dt-button buttons-html5" );
        $('input[type=search]').addClass('form-control border-0 bg-light');
    });
}