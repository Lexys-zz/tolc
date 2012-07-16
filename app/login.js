$(function () {
    var project_url = $("#project_url").val();
    var btn_do_login_value = $("#btn_do_login_value").val();
    var btn_cancel_login_value = $("#btn_cancel_login_value").val();

    $("#login_form").dialog({
        autoOpen: true,
        show: "blind",
        hide: "explode",
        width: 600,
        height: 350,
        resizable: true,
        open: function () {
            $(this).load(project_url + '/app/ajax_login_form.php', {}, function() {
                $("#username").focus();
            });
            $('.ui-dialog-buttonpane').find('button:contains("' + btn_do_login_value + '")').button({
                icons: {
                    primary: 'ui-icon-check'
                }
            });
            $('.ui-dialog-buttonpane').find('button:contains("' + btn_cancel_login_value + '")').button({
                icons: {
                    primary: 'ui-icon-cancel'
                }
            });
        },
        buttons: [
            {
                text: btn_do_login_value,
                click: function () {
                    switch (validate_login_form()) {
                        case 1:
                            $("#username").addClass("ui-state-error");
                            update_user_message($("#msg_username_required").val());
                            break;
                        case 2:
                            $("#password").addClass("ui-state-error");
                            update_user_message($("#msg_password_required").val());
                            break;
                        default:
                            $.ajax({
                                type: 'POST',
                                url: $("#project_url").val() + "/app/ajax_login.php",
                                data: {
                                    username: $("#username").val(),
                                    password: $("#password").val(),
                                    language: $("#language").val(),
                                    timezone: $("#timezone").val()
                                },
                                success: function (data) {
                                    if (data == '') {
                                        location.reload();
                                    } else {
                                        update_user_message(data);
                                    }
                                }
                            });
                    }

                }
            },
            {
                text: btn_cancel_login_value,
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });

    $('#login_form').keypress(function (e) {
        if (e.keyCode == $.ui.keyCode.ENTER) {
            $('.ui-button:contains("' + btn_do_login_value + '")').click()
        }
    });


    $(document).on("focus", "#username", function(event){
        $("#username").removeClass("ui-state-error");
        $("#user_message").html('');
    });

    $(document).on("focus", "#password", function(event){
        $("#password").removeClass("ui-state-error");
        $("#user_message").html('');
    });

});


function validate_login_form() {
    if ($("#username").val() == '') {
        return 1;
    }
    if ($("#password").val() == '') {
        return 2;
    }
    return 0;
}

function update_user_message(t) {
    $("#user_message").text(t)
    $("#user_message").addClass("ui-state-highlight");
    setTimeout(function () {
        $("#user_message").removeClass("ui-state-highlight", 1500);
    }, 500);
}
