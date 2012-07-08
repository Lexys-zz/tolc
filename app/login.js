$(function () {

    $("#login_form").dialog({
        autoOpen: true,
        show: "blind",
        hide: "explode",
        width: 600,
        height: 300,
        resizable: true,
        open: function () {
            $('.ui-dialog-buttonpane').find('button:contains("Login")').button({
                icons: {
                    primary: 'ui-icon-check'
                }
            });
            $('.ui-dialog-buttonpane').find('button:contains("Cancel")').button({
                icons: {
                    primary: 'ui-icon-cancel'
                }
            })
        },
        buttons: [
            {
                text: $("#btn_do_login_value").val(),
                click: function () {
                    switch (validate_login_form()) {
                        case 1:
                            $("#username").addClass( "ui-state-error" );
                            update_user_message($("#msg_username_required").val());
                            break;
                        case 2:
                            $("#password").addClass( "ui-state-error" );
                            update_user_message($("#msg_password_required").val());
                            break;
                        default:
                            $.ajax({
                                type: 'POST',
                                url: $("#project_url").val() + "/app/ajax_login.php",
                                data: {
                                    username: $("#username").val(),
                                    password: $("#password").val(),
                                    language: $("#language").val()
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
                text: $("#btn_cancel_login_value").val(),
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });

    $("#username").focus(function() {
        $("#username").removeClass("ui-state-error" );
        $("#user_message").html('');
    });

    $("#password").focus(function() {
        $("#password").removeClass("ui-state-error" );
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
