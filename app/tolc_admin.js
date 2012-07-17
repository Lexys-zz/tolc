$(function () {
    var btn_ok = $("#btn_ok").val();
    var active_elements = $("#active_elements").val();
    var content = 'test';

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

    $("#tp_filemanager").click(function () {
        var url = $("#ezfilemanager_url").val();
        var win_name = 'ezfm';
        CenterWindow(750, 625, 50, url, win_name);
    });

    $("#tp_logout").click(function () {
        $.ajax({
            url: $("#project_url").val() + "/app/admin/logout/ajax_logout.php",
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
            $(this).css('cursor','crosshair');
        }
    }, function () {
        $(this).data("bouncing", false);
        $(this).css('cursor','auto');
    });

    $(active_elements).click(function () {
        var url = $("#project_url").val() + '/app/rte.php';
        var win_name = 'rte';
        CenterWindow(1200, 800, 50, url, win_name);
    });

});