$(function () {

    var project_url = $("#project_url").val();
    var ajax_loading = $("#ajax_loading").val();

    var rsc_help_toggle = $("#rsc_help_toggle").val();
    var btn_ok_value = $("#btn_ok").val();
    var btn_save_value = $("#btn_save").val();
    var btn_cancel_value = $("#btn_cancel").val();

    var ezfilemanager_url = $("#ezfilemanager_url").val();
    var active_elements = $("#active_elements").val();

    var rsc_username_charset = $("#rsc_username_charset").val();
    var rsc_password_charset = $("#rsc_password_charset").val();
    var rsc_password_maxchars = $("#rsc_password_maxchars").val();
    var rsc_password_minchars = $("#rsc_password_minchars").val();
    var rsc_suggested_password_length = $("#rsc_suggested_password_length").val();
    var rsc_password_mask = $("#rsc_password_mask").val();
    var rsc_password_unmask = $("#rsc_password_unmask").val();

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
        autoOpen: $("#must_change_passwd").val() == '1' ? true : false,
        show: "blind",
        hide: "explode",
        width: 740,
        height: 520,
        resizable: true,
        modal: $("#must_change_passwd").val() == '1' ? true : false,
        open: function () {
            $(this).load(project_url + '/app/admin/user/ajax_user_form.php', {}, function () {

                var regex_username_filter = new RegExp('[^' + escapeRegexJS(rsc_username_charset) + ']', 'g');
                var regex_password_filter = new RegExp('[^' + escapeRegexJS(rsc_password_charset) + ']', 'g');

                //The focus event does not bubble in Internet Explorer
                $('#username').focus();

                // disable right click in username and password fields (as right click -> paste cannot easily detected to all browsers)
                $("#username, #old_password, #new_password, #repeat_new_password").contextmenu(function () {
                    return false;
                });

                $('#new_password').passwordStrength({
                    username: $("#username").val(),
                    minchars: rsc_password_minchars,
                    regexp: regex_password_filter,
                    strength_indicator: 'password_strength_indicator'
                });

                $('#generate_password').click(function () {
                    var pwd_size = Math.min(rsc_suggested_password_length, rsc_password_maxchars);
                    var random_password = randomPassword(rsc_password_charset, pwd_size);
                    $("#new_password").val(random_password).triggerHandler('keyup');
                    $("#repeat_new_password").val(random_password);
                });

                $("#mask_password_toggle").toggle(
                    function () {
                        $(this).text(rsc_password_mask);
                        $('#old_password, #new_password, #repeat_new_password').prop('type', 'text');
                    },
                    function () {
                        $(this).text(rsc_password_unmask);
                        $('#old_password, #new_password, #repeat_new_password').prop('type', 'password');
                    }
                );

                $('#username').keyup(function () {

                    $(this).val($(this).val().replace(regex_username_filter, ''));

                    if ($("#new_password").val() != '') {
                        $('#new_password').passwordStrength({
                            username: $("#username").val(),
                            minchars: rsc_password_minchars,
                            regexp: regex_password_filter,
                            strength_indicator: 'password_strength_indicator'
                        }).triggerHandler('keyup');
                    }
                });

                $('#old_password, #repeat_new_password').keyup(function () {
                    $(this).val($(this).val().replace(regex_password_filter, ''));
                });

                $("#help_toggle").toggle(
                    function () {
                        $(this).text(rsc_help_toggle + ' [-]');
                        $('.help_call').css('display', 'inline-block');
                    },
                    function () {
                        $(this).text(rsc_help_toggle + ' [+]');
                        $('.help_call').css('display', 'none');
                    }
                );
                // help tips
                $('a[id*=help-]').each(function () {
                    $(this).qtip(
                        {
                            content: {
                                text: '<img src="' + project_url + '/app/images/throbber.gif" alt="' + ajax_loading + '..." />',
                                ajax: {
                                    url: project_url + '/app/help/help.php?id=' + $(this).attr('id')
                                },
                                title: {
                                    text: $(this).attr('rel'),
                                    button: true
                                }
                            },
                            position: {
                                at: 'bottom center', // Position the tooltip above the link
                                my: 'top center',
                                viewport: $(window), // Keep the tooltip on-screen at all times
                                effect: false // Disable positioning animation
                            },
                            show: {
                                event: 'click',
                                solo: true // Only show one tooltip at a time
                            },
                            hide: 'unfocus',
                            style: {
                                classes: 'ui-tooltip-bootstrap'
                            }
                        })
                })

                    // Make sure it doesn't follow the link when we click it
                    .click(function (event) {
                        event.preventDefault();
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
                            $("#username").focus();
                            update_user_message($("#msg_username_required").val());
                            break;
                        case 2:
                            $("#old_password").focus();
                            update_user_message($("#msg_old_password_required").val());
                            break;
                        case 3:
                            $("#new_password").focus();
                            update_user_message($("#msg_new_password_required").val());
                            break;
                        case 4:
                            $("#repeat_new_password").focus();
                            update_user_message($("#msg_password_verification_required").val());
                            break;
                        case 5:
                            $("#fullname").focus();
                            update_user_message($("#msg_user_fullname_required").val());
                            break;
                        case 6:
                            $("#email").focus();
                            update_user_message($("#msg_user_email_required").val());
                            break;
                        default:
                            $.ajax({
                                type: 'POST',
                                url: project_url + "/app/admin/user/ajax_user.php",
                                data: {
                                    username: $("#username").val(),
                                    old_password: $("#old_password").val(),
                                    new_password: $("#new_password").val(),
                                    repeat_new_password: $("#repeat_new_password").val(),
                                    fullname: $("#fullname").val(),
                                    email: $("#email").val(),
                                    url: $("#url").val(),
                                    password_strength: parseInt($("#password_strength_indicator").text())
                                },
                                success: function (data) {
                                    if (data == '') {
                                        $("#login_user").text($("#username").val());
                                        $("#must_change_passwd").val('0');
                                        $("#user_form").dialog("close");
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
        ],
        beforeClose: function (event, ui) {
            if ($("#must_change_passwd").val() == '1') {
                return false; // cancel close event (in modal mode if password has not changed)
            }
        }
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
        height: 600,
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
    var pl1 = $("#old_password").val().length;
    var pl2 = $("#new_password").val().length;
    var pl3 = $("#repeat_new_password").val().length;
    var pl = pl1 + pl2 + pl3;

    if ($("#username").val().length == 0) {
        return 1;
    }

    if (pl > 0 || $("#must_change_passwd").val() == '1') {
        if (pl1 == 0) {
            return 2;
        }
        if (pl2 == 0) {
            return 3;
        }
        if (pl3 == 0) {
            return 4;
        }
    }

    if ($("#fullname").val().length == 0) {
        return 5;
    }
    if ($("#email").val().length == 0) {
        return 6;
    }
    return 0;
}

function update_user_message(t) {
    $("#user_message").text(t)
    $("#user_message").addClass("ui-state-highlight");
    setTimeout(function () {
        $("#user_message").removeClass("ui-state-highlight");
        $("#user_message").text('');
    }, 1500);
}