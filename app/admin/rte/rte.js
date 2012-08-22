$(function () {
    var project_url = $("#project_url", window.opener.document).val();
    var tinymce_url = $("#tinymce_url", window.opener.document).val();
    var ezfilemanager_url = $("#ezfilemanager_url", window.opener.document).val();
    var content_css_url = $("#content_css_url", window.opener.document).val();
    var base_url = $("#base_url", window.opener.document).val();

    var lang = $("#lang").val();
    var dateformat = $("#dateformat").val();
    var timeformat = $("#timeformat").val();
    var pref_tinymce_toggle_toolbar = $("#pref_tinymce_toggle_toolbar").val() == '1' ? true : false;
    var rsc_please_select = $("#rsc_please_select").val();

    /* timnymce --------------------------------------------------------------*/
    $("#rte").tinymce({
        // Location of TinyMCE script
        script_url: tinymce_url,

        // General options
        theme: "advanced",
        plugins: "advhr,advimage,advlink,advlist,contextmenu," +
            "emotions,inlinepopups,insertdatetime," +
            "lists,media,nonbreaking," +
            "paste,print,searchreplace,style," +
            "table,visualchars," +
            "ezfilemanager",
        language: lang,
        entity_encoding: "raw",
        relative_urls: true, // default
        document_base_url: base_url,

        // Theme options
        theme_advanced_buttons1: "code,cleanup,|,formatselect,styleprops,|,bold,italic,underline,strikethrough,|,sub,sup,|," +
            ",justifyleft,justifycenter,justifyright,justifyfull,|,outdent,indent,blockquote,|,forecolor,backcolor,|" +
            ",link,unlink,anchor,image,media,|,bullist,numlist,|,tablecontrols,",
        theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,selectall,|,undo,redo,|,search,replace,|" +
            ",print,|,styleselect,fontselect,fontsizeselect,|,removeformat,visualaid,|,advhr,nonbreaking,|" +
            ",visualchars,charmap,insertdate,inserttime,emotions,|,help",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,

        // Example content CSS (should be your site CSS)
        content_css: content_css_url,

        setup: function (ed) {
            if (pref_tinymce_toggle_toolbar) {
                ed.onInit.add(function (ed) {
                    $('#rte_tbl .mceToolbar').hide();

                    ed.getDoc().addEventListener("blur", function () {
                        $('#rte_tbl .mceToolbar').hide();
                    }, true);

                    ed.getDoc().addEventListener("focus", function () {
                        $('#rte_tbl .mceToolbar').show();
                    }, true);
                });
            } else {
                var do_nothing = 0; // MSIE < 9.0
            }
        },

        file_browser_callback: function (field_name, url, type, win) {
            var cmsURL = ezfilemanager_url + "?type=" + type + "&tmce=1";
            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                width: 720, // Your dimensions may differ - play with them, but dont forget the css!
                height: 600,
                resizable: "yes",
                scrollbars: "yes",
                inline: "no",
                close_previous: "no"
            }, {
                window: win,
                input: field_name,
                editor_id: tinyMCE.selectedInstance.editorId
            });

            return false;
        }
    });


    /* misc controls ---------------------------------------------------------*/
    $("#btn_remove").button({
        text: '',
        icons: {
            primary: 'ui-icon ui-icon-arrowthickstop-1-s'
        }
    });

    $("#btn_activate").button({
        text: '',
        icons: {
            primary: 'ui-icon ui-icon-arrowthickstop-1-n'
        }
    });

    $("#btn_save").button({
        text: '',
        icons: {
            primary: 'ui-icon-disk'
        }
    });

    $("#btn_delete").button({
        text: '',
        icons: {
            primary: 'ui-icon-trash'
        }
    });

    $("#btn_clone").button({
        text: '',
        icons: {
            primary: 'ui-icon-copy'
        }
    });

    $("#date_publish_start").datetimepicker(
        {
            dateFormat: dateformat,
            timeFormat: timeformat,
            showSecond: true,
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true
        },
        $.datepicker.regional[ lang ],
        $.timepicker.regional[ lang ]
    );

    $("#date_publish_end").datetimepicker(
        {
            dateFormat: dateformat,
            timeFormat: timeformat,
            showSecond: true,
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true
        },
        $.datepicker.regional[ lang ],
        $.timepicker.regional[ lang ]
    );

    /* filedset legend effect ------------------------------------------------*/
    $('legend').siblings().hide();

    $('legend').click(function () {
        $(this).siblings().slideToggle("slow");
    });

    /* controls events -------------------------------------------------------*/
    $('#btn_remove').click(function () {
        var www_page_versions_id = $('#www_page_versions_id').val();
        remove_page('1', www_page_versions_id);
    });

    $('#btn_activate').click(function () {
        var www_page_versions_id = $('#www_page_versions_id').val();
        remove_page('0', www_page_versions_id);
    });

    $('#btn_delete').click(function () {
        var www_page_versions_id = $('#www_page_versions_id').val();
        delete_page_version(www_page_versions_id);
    });

    $('#btn_save').click(function () {
        var www_page_versions_id = $('#www_page_versions_id').val();
        save_page_version(www_page_versions_id);
    });

    $('#www_page_versions_id').change(function () {
        var www_page_versions_id = $('#www_page_versions_id').val();
        load_page_version(www_page_versions_id);
    });


    /* arrange controls and load page version --------------------------------*/
    remove_page_controls_toggle($("#page_has_been_removed").val());

    load_page_version($("#start_page_versions_id").val());

});


// -----------------------------------------------------------------------------
function remove_page_controls_toggle(page_has_been_removed) {
    if(page_has_been_removed == '1') {
        $("#btn_remove, #page_remove").hide();
        $("#btn_activate, #page_activate").show();
    } else {
        $("#btn_remove, #page_remove").show();
        $("#btn_activate, #page_activate").hide();
    }
}

// -----------------------------------------------------------------------------
function load_page_version(www_page_versions_id) {

    var project_url = $("#project_url", window.opener.document).val();
    var rsc_please_select = $("#rsc_please_select").val();

    // load content to tinymce
    $.ajax({
        type: 'POST',
        url: project_url + "/app/admin/rte/ajax_load_page_version.php",
        data: {
            www_page_versions_id: www_page_versions_id
        },
        success: function (data) {

            var j = $.parseJSON(data);
            create_page_versions(j.page_versions, j.content_status_css, 1)
            create_authors(j.authors, 0, '');
            create_content_status(j.content_status_keys, j.content_status_values, j.content_status_css, 0);
            create_editors(j.editors, 0, rsc_please_select);
            $("#rte").html(j.html);
        }
    });

}


function create_page_versions(a_data, a_css_class, selid) {
    var options = '';
    $.each(a_data, function (index, value) {
        var i = a_data[index].content_status;
        var css_class = 'class="' + a_css_class[i] + '" ';
        var selected = (selid == a_data[index].version_id ? ' selected' : '');
        options += '<option ' + css_class + 'value="' + a_data[index].version_id + '"' + selected + '>' + a_data[index].version + '</option>';
    });
    $("#www_page_versions_id").html(options);

}


function create_authors(a_data, selid, please_select) {
    var options = '';
    if (please_select) {
        options += '<option value="0">' + please_select + ' </option>';
    }
    $.each(a_data, function (index, value) {
        var selected = (selid == a_data[index].id ? ' selected' : '');
        options += '<option value="' + a_data[index].id + '"' + selected + '>' + a_data[index].fullname + '</option>';
    });
    $("#author_id").html(options);

}

function create_content_status(a_keys, a_val, a_css_class, selid) {
    var options = '';

    $.each(a_keys, function (index, value) {
        var css_class = 'class="' + a_css_class[value] + '" ';
        var selected = (selid == value ? ' selected' : '');
        options += '<option ' + css_class + 'value="' + value + '"' + selected + '>' + a_val[index] + '</option>';
    });
    $("#lk_content_status_id").html(options);

}

function create_editors(a_data, selid, please_select) {
    var options = '';
    if (please_select) {
        options += '<option value="0">' + please_select + ' </option>';
    }
    $.each(a_data, function (index, value) {
        var selected = (selid == a_data[index].id ? ' selected' : '');
        options += '<option value="' + a_data[index].id + '"' + selected + '>' + a_data[index].fullname + '</option>';
    });
    $("#editor_id").html(options);

}


// -----------------------------------------------------------------------------
function save_page_version(www_page_versions_id) {

    var project_url = $("#project_url", window.opener.document).val();

    // load content to tinymce
    $.ajax({
        type: 'POST',
        url: project_url + "/app/admin/rte/ajax_save_page_version.php",
        data: {
            www_page_versions_id: www_page_versions_id
        },
        success: function (data) {
            load_page_version(www_page_versions_id);
        }
    });
}


// -----------------------------------------------------------------------------
function delete_page_version(www_page_versions_id) {

    var project_url = $("#project_url", window.opener.document).val();
    $.ajax({
        type: 'POST',
        url: project_url + "/app/admin/rte/ajax_delete_page_version.php",
        data: {
            www_page_versions_id: www_page_versions_id
        },
        success: function (data) {
            load_page_version(0);
        }
    });
}

// -----------------------------------------------------------------------------
function remove_page(flag, page_version_id) {

    var project_url = $("#project_url", window.opener.document).val();
    $.ajax({
        type: 'POST',
        url: project_url + "/app/admin/rte/ajax_remove_page.php",
        data: {
            flag: flag
        },
        success: function (data) {
            if($.trim(data) == '') {
                remove_page_controls_toggle(flag);
                load_page_version(page_version_id);
                opener.location.reload();
            } else {
                var msg = 'ERROR ' + data;
                update_user_message(msg);
            }
        }
    });
}

// -----------------------------------------------------------------------------
function update_user_message(msg) {
    $("#user_message").jui_alert({
        message: msg
    });
}