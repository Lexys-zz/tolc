$(function () {

    var project_url = $("#project_url").val();
    var ezfilemanager_url = $("#ezfilemanager_url").val();
    var active_elements = $("#active_elements").val();
    var btn_ok_value = $("#btn_ok").val();
    var btn_save_value = $("#btn_save").val();
    var btn_cancel_value = $("#btn_cancel").val();

    /* slide ---------------------------------------------------------------- */
    $("#tolc_btn_slide").click(function () {
        $("#tolc_panel").slideToggle("slow");
        return false;
    });

    /* buttons -------------------------------------------------------------- */
    $("#tp_edit_page").button({
        icons: {
            primary: 'ui-icon-pencil'
        }
    });

    $("#tp_sitemap").button({
        icons: {
            primary: 'ui-icon-pin-w'
        }
    });

    $("#tp_templates").button({
        icons: {
            primary: 'ui-icon-wrench'
        }
    });

    $("#tp_filemanager").button({
        icons: {
            primary: 'ui-icon-folder-open'
        }
    });

    $("#tp_users").button({
        icons: {
            primary: 'ui-icon-person'
        }
    });

    $("#tp_about").button({
        icons: {
            primary: 'ui-icon-home'
        }
    });

    $("#tp_logout").button({
        icons: {
            primary: 'ui-icon-power'
        }
    });

    /* user form ------------------------------------------------------------ */
    $("#user_form").dialog({
        autoOpen: false,
        show: "blind",
        hide: "explode",
        width: 700,
        height: 500,
        resizable: true,
        open: function () {
            $(this).load(project_url + '/app/admin/user/ajax_user_form.php', {}, function () {
                $("#username").focus();

                $('#new_password').passwordStrength({
                    username: $("#username").val(),
                    minchars: 2
                });

                $('#generate_password').click(function () {
                    var random_password = randomPassword();
                    $("#new_password").val(random_password).triggerHandler('keyup');
                    $("#repeat_new_password").val(random_password);
                    //return false;
                });

                $("#mask_password_toggle").toggle(
                    function () {
                        $(this).text('Mask');
                        $('#old_password, #new_password, #repeat_new_password').prop('type', 'text');
                    },
                    function () {
                        $(this).text('Unmask');
                        $('#old_password, #new_password, #repeat_new_password').prop('type', 'password');
                    }
                );

                $('#username').keyup(function() {
                    if($("#new_password").val() != '') {
                        $('#new_password').passwordStrength({
                            username: $("#username").val(),
                            minchars: 2
                        }).triggerHandler('keyup');
                        //return false;
                    }
                });
            });
            $('.ui-dialog-buttonpane').find('button:contains("' + btn_save_value + '")').button({
                icons: {
                    primary: 'ui-icon-check'
                }
            });
            $('.ui-dialog-buttonpane').find('button:contains("' + btn_cancel_value + '")').button({
                icons: {
                    primary: 'ui-icon-cancel'
                }
            });
        },
        buttons: [
            {
                text: btn_save_value,
                click: function () {
                    switch (validate_user_form()) {
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
                                url: project_url + "/app/admin/user/ajax_user.php",
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
                text: btn_cancel_value,
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });



    $("#login_user").click(function () {
        $("#user_form").dialog("open");
        return false;
    });



    /* about form ----------------------------------------------------------- */
    $("#about_tolc_form").dialog({
        autoOpen: false,
        show: "blind",
        hide: "explode",
        width: 700,
        height: 400,
        resizable: true,
        open: function () {
            $(this).load(project_url + '/app/admin/about/ajax_about_form.php');
            $('.ui-dialog-buttonpane').find('button:contains("' + btn_ok_value + '")').button({
                icons: {
                    primary: 'ui-icon-check'
                }
            });
        },
        buttons: [
            {
                text: btn_ok_value,
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });

    $("#tp_about").click(function () {
        $("#about_tolc_form").dialog("open");
        return false;
    });

    /* filemanager ---------------------------------------------------------- */
    $("#tp_filemanager").click(function () {
        var url = ezfilemanager_url;
        var win_name = 'ezfm';
        CenterWindow(750, 625, 50, url, win_name, '');
    });

    /* logout -------------------------------------------------------------- */
    $("#tp_logout").click(function () {
        $.ajax({
            url: project_url + "/app/admin/logout/ajax_logout.php",
            success: function (data) {
                location.reload();
            }
        });
    });

    /* active elements ------------------------------------------------------ */
    $(active_elements).hover(function () {
            $(this).addClass('over');
        },
        function () {
            $(this).removeClass('over');
        });

    $(active_elements).qtip({
        content: {
            text: '<a href="javascript:void(0)" onclick="rte()">Click here</a>',
            title: {
                text: 'Edit',
                button: false
            }
        },
        position: {
            my: 'center',
            at: 'center'
        },
        style: {
            classes: 'ui-tooltip-shadow ui-tooltip-bootstrap'
        },
        hide: {
            fixed: true,
            delay: 100
        }
    });

});

function rte() {
    var url = $("#project_url").val() + '/app/admin/rte/rte.php';
    var win_name = 'rte';
    CenterWindow(1200, 800, 50, url, win_name, '');
}

function validate_user_form() {

}

function update_user_message(t) {
    $("#user_message").text(t)
    $("#user_message").addClass("ui-state-highlight");
    setTimeout(function () {
        $("#user_message").removeClass("ui-state-highlight", 1500);
    }, 500);
}