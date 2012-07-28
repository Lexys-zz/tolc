$(function () {

    var project_url = $("#project_url").val();
    var ezfilemanager_url = $("#ezfilemanager_url").val();
    var active_elements = $("#active_elements").val();
    var btn_ok_value = $("#btn_ok").val();

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
        $( "#about_tolc_form" ).dialog( "open" );
        return false;
    });


    $("#tp_filemanager").click(function () {
        var url = ezfilemanager_url;
        var win_name = 'ezfm';
        CenterWindow(750, 625, 50, url, win_name, '');
    });

    $("#tp_logout").click(function () {
        $.ajax({
            url: project_url + "/app/admin/logout/ajax_logout.php",
            success: function (data) {
                location.reload();
            }
        });
    });

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