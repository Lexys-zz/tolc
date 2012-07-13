$(function () {
    var btn_ok = $("#btn_ok").val();
    var active_elements = $("#active_elements").val();

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

    if ($("#login").val() == '1') {
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

    $(active_elements).hover(function () {
        if ($(this).data("bouncing") == false || $(this).data("bouncing") == undefined) {
            $(this).effect("bounce", { direction: 'up', distance: 10, times: 1 });
            $(this).data("bouncing", true);
        }
    }, function () {
        $(this).data("bouncing", false);
    });

    $(active_elements).click(function () {
        alert($(this).html());
    });

});