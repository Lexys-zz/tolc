$(function () {
    var project_url = $("#project_url").val();
    var btn_do_new_page_value = $("#btn_do_new_page").val();
    var btn_cancel_new_page_value = $("#btn_cancel_new_page").val();

    $("#new_page_form").dialog({
        autoOpen: true,
        show: "blind",
        hide: "explode",
        width: 700,
        height: 400,
        resizable: true,
        open: function () {
            $(this).load(project_url + '/app/admin/new_page/ajax_new_page_form.php', {}, function () {
                $("#page_url").focus();
                $("#parent_title").autocomplete({
                    source: project_url + '/app/admin/new_page/ajax_autocomplete_parent_title.php',
                    minLength: 2,
                    html: true,
                    select: function (event, ui) {
                        $("#parent_id").val(ui.item.id);
                    },
                    // mustMatch implementation
                    change: function (event, ui) {
                        if (ui.item == null) {
                            $(this).val('');
                            $('#parent_id').val('');
                        }
                    }
                });

                // mustMatch (no value) implementation
                $("#parent_title").focusout(function() {
                    if ($("#parent_title").val() == '') {
                        $('#parent_id').val('');
                    }
                });
            });
            $('.ui-dialog-buttonpane').find('button:contains("' + btn_do_new_page_value + '")').button({
                icons: {
                    primary: 'ui-icon-check'
                }
            });
            $('.ui-dialog-buttonpane').find('button:contains("' + btn_cancel_new_page_value + '")').button({
                icons: {
                    primary: 'ui-icon-cancel'
                }
            });
        },
        buttons: [
            {
                text: btn_do_new_page_value,
                click: function () {
                    switch (validate_new_page_form()) {
                        case 1:
                            $("#page_url").focus();
                            update_user_message($("#msg_page_url_required").val());
                            break;
                        case 2:
                            $("#page_title").focus();
                            update_user_message($("#msg_page_title_required").val());
                            break;
                        case 3:
                            $("#www_templates_id").focus();
                            update_user_message($("#msg_template_required").val());
                            break;
                        case 4:
                            $("#parent_title").focus();
                            update_user_message($("#msg_parent_required").val());
                            break;
                        default:
                            $.ajax({
                                type: 'POST',
                                url: project_url + "/app/admin/new_page/ajax_new_page.php",
                                data: {
                                    page_url: $("#page_url").val(),
                                    page_title: $("#page_title").val(),
                                    www_templates_id: $("#www_templates_id").val(),
                                    parent_id: $("#parent_id").val()
                                },
                                success: function (data) {
                                    if ($.trim(data) == '') {
                                        window.location = project_url + $("#page_url").val();
                                    } else {
                                        update_user_message(data);
                                    }
                                }
                            });
                    }
                }
            },
            {
                text: btn_cancel_new_page_value,
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });



    $('#new_page_form').keypress(function (e) {
        if (e.keyCode == $.ui.keyCode.ENTER) {
            $('.ui-button:contains("' + btn_do_new_page_value + '")').click()
        }
    });

});


function validate_new_page_form() {
    if ($("#page_url").val().length == 0) {
        return 1;
    }
    if ($("#page_title").val().length == 0) {
        return 2;
    }
    if ($("#www_templates_id").val().length == 0) {
        return 3;
    }
    if ($("#parent_id").val().length == 0) {
        return 4;
    }
    return 0;
}

function update_user_message(msg) {
    $("#user_message").jui_alert({
        message: msg
    });
}
