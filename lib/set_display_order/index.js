$(function() {
    $("#btn_sort_top, #btn_sort_bottom").button({
        icons: {
            primary:'ui-icon-disk'
        }
    });
});

$(function() {
    $("#btn_close_top, #btn_close_bottom").button({
        icons: {
            primary:'ui-icon-circle-close'
        }
    });
});

$(function() {
    $("#sortable").sortable({
        placeholder: "ui-state-highlight"
    });
    $("#sortable").disableSelection();
});

function DoSort() {
    
    var a_ordered_ids = $('#sortable').sortable('toArray');
    var ordered_ids = a_ordered_ids.join("|");

    $.ajax({
        type: 'POST',
        url: 'ajax_update_display_order.php',
        data: {
            ordered_ids: ordered_ids,
            table_name: $("#table_name").val(),
            id_field_name: $("#id_field_name").val(),
            display_order_field_name: $("#display_order_field_name").val()
        },
        beforeSend:function() {
            //$('#AjaxLoader').html('<img src="../../images/ajax-loader-01.gif">');
        },
        success:function(data) {
            //$('#AjaxLoader').empty();

            window.opener[$("#function_to_call").val()]();
        },
        error:function() {
            //alert(err_msg_ajax_call_failed);
        }
    });

}

function DoClose() {
    window.close();
}
