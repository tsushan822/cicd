$("#file_select").on("change", function () {
    $(".import_button").hide();
    $(".import_button_large").hide();
});

function previewInfo(module) {
    var file_excel = module + "_upload_excel.xlsx";
    var file_csv = module + "_upload_csv.csv";
    $("#download_template_excel").attr("href", "/Related/Template/" + file_excel);
    $("#download_template_csv").attr("href", "/Related/Template/" + file_csv);
    $("#getInfoModal").modal('show');
}

function previewExcelFile(module) {
    var url = "/" + module + "/check";
    var formData = "#" + module + "_upload";
    var importButton = "#" + module + "_import_button";
    var importButtonLarge = "#" + module + "_import_large";
    $("#getCodeModal").modal('show');
    $.ajax({
        type: "POST",
        url: url,
        processData: false,
        contentType: false,
        data: new FormData($(formData)[0]),
        success: function success(response) {
            if (response.warning === false) {
                displayInfo('Please select a file to import..', "Errors !!!", "#ff0000");
            } else {
                var num = response.warning.length;

                if (num > 0) {
                    var displayValue = '';

                    for (var i = 0; i < num; i++) {
                        displayValue += response.warning[i] + "<br>";
                    }

                    displayInfo(displayValue, "Errors !!!", "#ff0000");
                } else {
                    var displayValue = '';
                    var numInfo = (response.info !== 'undefined') ? response.info.length : 0;
                    if (numInfo > 0) {
                        for (var i = 0; i < numInfo; i++) {
                            displayValue += response.info[i] + "<br>";
                        }
                    }
                    displayInfo(displayValue, "Success !!", "#008000");
                    $(importButton).show();
                    $(importButtonLarge).show();
                }
            }
        },
        error: function error() {
            displayInfo("There is problem with file import, please contact " + "system administrator.", "Errors !!!", "#ff0000");
        }
    });
}

function displayInfo(displayValue, heading, color) {
    $("div.loader").hide();
    $("#getCode").html(displayValue);
    $("#myModalLabel").html(heading);
    document.getElementById("getCode").style.color = color;
}
