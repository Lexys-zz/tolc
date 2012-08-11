$(function () {
    var btn_ok = $("#btn_ok").val();

    $("#page_not_found").dialog({
        autoOpen: true,
        show: "blind",
        hide: "explode",
        width: 500,
        height: 200,
        buttons: [
            {
                text: btn_ok,
                click: function () {
                    $(this).dialog("close");
                }
            }
        ],
        open: function () {
            $('.ui-dialog-buttonpane').find('button:contains("' + btn_ok + '")').focus();
        }
    });
});