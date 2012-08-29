$(function() {
    var project_url = $("#project_url", window.opener.document).val();
    var tinymce_url = $("#tinymce_url", window.opener.document).val();
    var ezfilemanager_url = $("#ezfilemanager_url", window.opener.document).val();
    var content_css_url = $("#content_css_url", window.opener.document).val();
    var base_url = $("#base_url", window.opener.document).val();

    var www_pages_id = $("#www_pages_id", window.opener.document).val();
    var page_has_been_removed = $("#page_has_been_removed", window.opener.document).val();

    var lang = $("#lang").val();
    var dateformat = $("#dateformat").val();
    var timeformat = $("#timeformat").val();
    var pref_tinymce_toggle_toolbar = $("#pref_tinymce_toggle_toolbar").val() == '1' ? true : false;
    var rsc_please_select = $("#rsc_please_select").val();

    var minYear = $("#minYear").val();
    var minMonth = $("#minMonth").val();
    var minDay = $("#minDay").val();
    var minHour = $("#minHour").val();
    var minMin = $("#minMin").val();
    var minSec = $("#minSec").val();
    var minStartDate = new Date(minYear, minMonth - 1, minDay, minHour, minMin, minSec);

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

        setup: function(ed) {
            if(pref_tinymce_toggle_toolbar) {
                ed.onInit.add(function(ed) {
                    $('#rte_tbl .mceToolbar').hide();

                    ed.getDoc().addEventListener("blur", function() {
                        $('#rte_tbl .mceToolbar').hide();
                    }, true);

                    ed.getDoc().addEventListener("focus", function() {
                        $('#rte_tbl .mceToolbar').show();
                    }, true);
                });
            } else {
                var do_nothing = 0; // MSIE < 9.0
            }
        },

        file_browser_callback: function(field_name, url, type, win) {
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

    $("#btn_addnew").button({
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

    // TODO Setting mindate/maxdate via options only sets date
    // https://github.com/trentrichardson/jQuery-Timepicker-Addon/issues/398
    $("#date_publish_start").datetimepicker(
        {
            dateFormat: dateformat,
            timeFormat: timeformat,
            showSecond: true,
            changeMonth: true,
            changeYear: true,
            minDate: minStartDate,
            showButtonPanel: true,
            onSelect: function(dateText, inst) {
                $.ajax({
                    type: 'POST',
                    url: project_url + "/app/admin/rte/ajax_datetime_range.php",
                    data: {
                        dt: dateText
                    },
                    success: function(data) {
                        var j = $.parseJSON(data);
                        var minEndDate = new Date(j.minYear, j.minMonth - 1, j.minDay, j.minHour, j.minMin, j.minSec);
                        $("#date_publish_end").datepicker("option", "minDate", minEndDate);
                    }
                });
            }
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
            minDate: minStartDate,
            showButtonPanel: true
        },
        $.datepicker.regional[ lang ],
        $.timepicker.regional[ lang ]
    );

    /* filedset legend effect ------------------------------------------------*/
    $('legend').siblings().hide();

    $('legend').click(function() {
        $(this).siblings().slideToggle("slow");
    });

    /* controls events -------------------------------------------------------*/
    $('#btn_remove').click(function() {
        var www_page_versions_id = $('#www_page_versions_id').val();
        remove_page('1', www_page_versions_id);
    });

    $('#btn_activate').click(function() {
        var www_page_versions_id = $('#www_page_versions_id').val();
        remove_page('0', www_page_versions_id);
    });

    $('#www_page_versions_id').change(function() {
        var www_page_versions_id = $('#www_page_versions_id').val();
        load_page_version(www_page_versions_id);
    });

    $('#btn_delete').click(function() {
        var www_page_versions_id = $('#www_page_versions_id').val();
        delete_page_version(www_page_versions_id);
    });

    $('#btn_clone').click(function() {
        var www_page_versions_id = $('#www_page_versions_id').val();
        clone_page_version(www_page_versions_id);
    });

    $('#btn_save').click(function() {
        var www_page_versions_id = $('#www_page_versions_id').val();
        save_page_version(www_page_versions_id);
    });

    $('#btn_addnew').click(function() {
        addnew_page_version();
    });


    /* arrange remove page controls ------------------------------------------*/
    remove_page_controls_toggle($("#page_has_been_removed", window.opener.document).val());


    /* load page version -----------------------------------------------------*/
    load_page_version($("#start_page_versions_id").val());

})
;

// -----------------------------------------------------------------------------
function load_page_version(www_page_versions_id) {

    var project_url = $("#project_url", window.opener.document).val();
    var rsc_please_select = $("#rsc_please_select").val();
    var www_pages_id = $("#www_pages_id", window.opener.document).val();

    // load content to tinymce
    $.ajax({
        type: 'POST',
        url: project_url + "/app/admin/rte/ajax_load_page_version.php",
        data: {
            www_pages_id: www_pages_id,
            www_page_versions_id: www_page_versions_id
        },
        success: function(data) {

            var j = $.parseJSON(data);
            if(www_page_versions_id > 0) {
                create_page_versions(j.page_versions, j.content_status_css, 1)
            }
            create_authors(j.authors, j.current_version.author_id, '');
            $("#date_publish_start").val(j.current_version.date_publish_start);
            $("#date_publish_end").val(j.current_version.date_publish_end);
            create_content_status(j.content_status_keys, j.content_status_values, j.content_status_css, j.current_version.lk_content_status_id);
            create_editors(j.editors, j.current_version.editor_id, rsc_please_select);
            $("#rte").html(j.html);

            arrange_page_version_controls(www_page_versions_id);
        }
    });

}

function arrange_page_version_controls(www_page_versions_id) {
    if(www_page_versions_id > 0) {
        $("#www_page_versions_id, #lbl_www_page_versions_id, #btn_save, #btn_delete, #btn_clone").show();
        $("#new_page_version, #btn_addnew").hide();
    } else {
        $("#www_page_versions_id, #lbl_www_page_versions_id, #btn_save, #btn_delete, #btn_clone").hide();
        $("#new_page_version, #btn_addnew").show();
    }
}

function create_page_versions(a_data, a_css_class, selid) {
    var options = '';
    $.each(a_data, function(index, value) {
        var i = a_data[index].content_status;
        var css_class = 'class="' + a_css_class[i] + '" ';
        var selected = (selid == a_data[index].version_id ? ' selected' : '');
        options += '<option ' + css_class + 'value="' + a_data[index].version_id + '"' + selected + '>' + a_data[index].version + '</option>';
    });
    $("#www_page_versions_id").html(options);

}


function create_authors(a_data, selid, please_select) {
    var options = '';
    if(please_select) {
        options += '<option value="0">' + please_select + ' </option>';
    }
    $.each(a_data, function(index, value) {
        var selected = (selid == a_data[index].id ? ' selected' : '');
        options += '<option value="' + a_data[index].id + '"' + selected + '>' + a_data[index].fullname + '</option>';
    });
    $("#author_id").html(options);

}

function create_content_status(a_keys, a_val, a_css_class, selid) {
    var options = '';

    $.each(a_keys, function(index, value) {
        var css_class = 'class="' + a_css_class[value] + '" ';
        var selected = (selid == value ? ' selected' : '');
        options += '<option ' + css_class + 'value="' + value + '"' + selected + '>' + a_val[index] + '</option>';
    });
    $("#lk_content_status_id").html(options);

}

function create_editors(a_data, selid, please_select) {
    var options = '';
    if(please_select) {
        options += '<option value="0">' + please_select + ' </option>';
    }
    $.each(a_data, function(index, value) {
        var selected = (selid == a_data[index].id ? ' selected' : '');
        options += '<option value="' + a_data[index].id + '"' + selected + '>' + a_data[index].fullname + '</option>';
    });
    $("#editor_id").html(options);

}


// -----------------------------------------------------------------------------
function save_page_version(www_page_versions_id) {

    var project_url = $("#project_url", window.opener.document).val();
    $.ajax({
        type: 'POST',
        url: project_url + "/app/admin/rte/ajax_save_page_version.php",
        data: {
            www_page_versions_id: www_page_versions_id
        },
        success: function(data) {
            load_page_version(www_page_versions_id);
        }
    });
}

// -----------------------------------------------------------------------------
function addnew_page_version() {

    var project_url = $("#project_url", window.opener.document).val();
    var www_pages_id = $("#www_pages_id", window.opener.document).val();

    $.ajax({
        type: 'POST',
        url: project_url + "/app/admin/rte/ajax_addnew_page_version.php",
        data: {
            www_pages_id: www_pages_id,
            author_id: $("#author_id").val(),
            date_publish_start: $("#date_publish_start").val(),
            date_publish_end: $("#date_publish_end").val(),
            lk_content_status_id: $("#lk_content_status_id").val(),
            editor_id: $("#editor_id").val(),
            html: $("#rte").html()
        },
        success: function(data) {
            var j = $.parseJSON(data);
            load_page_version(j.www_page_versions_id);
            opener.location.reload();
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
        success: function(data) {
            load_page_version(0);
        }
    });
}

// -----------------------------------------------------------------------------
function clone_page_version(www_page_versions_id) {

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
        success: function(data) {
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
function update_user_message(msg) {
    $("#user_message").jui_alert({
        message: msg
    });
}