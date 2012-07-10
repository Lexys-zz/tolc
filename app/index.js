$(function () {
    var btn_ok = $("#btn_ok").val();

    if ($("#admin_mode").val() == '0' && $("#new_page").val() == '1') {
        $("#login_required_new_page").dialog({
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