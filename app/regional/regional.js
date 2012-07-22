$(function () {
    var project_url = $("#project_url").val();
    var btn_apply_regional_value = $("#btn_apply_regional_value").val();
    var btn_cancel_regional_value = $("#btn_cancel_regional_value").val();

    $("#regional_form").dialog({
        autoOpen: true,
        show: "blind",
        hide: "explode",
        width: 750,
        height: 270,
        resizable: true,
        open: function () {
            $(this).load(project_url + '/app/regional/ajax_regional_form.php', {}, function() {
                $("#timezone").focus();
            });
            $('.ui-dialog-buttonpane').find('button:contains("' + btn_apply_regional_value + '")').button({
                icons: {
                    primary: 'ui-icon-check'
                }
            });
            $('.ui-dialog-buttonpane').find('button:contains("' + btn_cancel_regional_value + '")').button({
                icons: {
                    primary: 'ui-icon-cancel'
                }
            });
        },
        buttons: [
            {
                text: btn_apply_regional_value,
                click: function () {
                    $.ajax({
                        type: 'POST',
                        url: project_url + "/app/regional/ajax_regional.php",
                        data: {
                            timezone: $("#timezone").val(),
                            dateformat: $("#dateformat").val()
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }
            },
            {
                text: btn_cancel_regional_value,
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });

    $('#regional_form').keypress(function (e) {
        if (e.keyCode == $.ui.keyCode.ENTER) {
            $('.ui-button:contains("' + btn_apply_regional_value + '")').click()
        }
    });

});
