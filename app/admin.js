$(function () {
    var btn_ok = $("#btn_ok").val();

    $("#tolc_btn_slide").click(function () {
        $("#tolc_panel").slideToggle("slow");
        return false;
    });

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

    $("#tp_users").button({
        icons: {
            primary: 'ui-icon-person'
        }
    });

    $("#tp_logout").button({
        icons: {
            primary: 'ui-icon-power'
        }
    });

    $("#tp_about").button({
        icons: {
            primary: 'ui-icon-home'
        }
    });

    $("#tp_logout").click(function () {
        $.ajax({
            url: $("#project_url").val() + "/app/ajax_logout.php",
            success: function (data) {
                location.reload();
            }
        });
    });

    if ($("#admin_mode").val() == '1' && $("#login").val() == '1') {
        $("#already_login").dialog({
            autoOpen: true,
            show: "blind",
            hide: "explode",
            width: 300,
            height: 200,
            buttons: [
                {
                    text: btn_ok,
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            ]
        });
    }

});