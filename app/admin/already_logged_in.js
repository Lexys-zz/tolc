$(function () {

    var btn_ok = $("#btn_ok").val();

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
});