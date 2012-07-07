$(function () {

    $("#login_form").dialog({
        autoOpen: true,
        show: "blind",
        hide: "explode",
        width: 500,
        height: 400
    });

    $("#btn_do_login").button({
        icons: {
            primary: 'ui-icon-check'
        }
    });

    $("#btn_cancel_login").button({
        icons: {
            primary: 'ui-icon-arrowreturnthick-1-w'
        }
    });

    $("#btn_cancel_login").click(function () {
        $("#login_form").dialog("close");
    });

    $("#btn_do_login").click(function () {
        if (validate_login_form() > 0) {

        } else {
            $.ajax({
                type: 'POST',
                url: $("#project_url").val() + "/app/ajax_login.php",
                data: {
                    username: $("#username").val(),
                    password: $("#password").val()
                },
                success: function (data) {
                    if (data == '') {
                        location.reload();
                        //$("#login_form").dialog("close");
                    } else {

                    }
                }
            });
        }
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