$(function () {
    var project_url = $("#project_url", window.opener.document).val();
    var tinymce_url = $("#tinymce_url", window.opener.document).val();
    var ezfilemanager_url = $("#ezfilemanager_url", window.opener.document).val();
    var content_css_url = $("#content_css_url", window.opener.document).val();
    var base_url = $("#base_url", window.opener.document).val();

    var lang = $("#lang").val();
    var dateformat = $("#dateformat").val();
    var pref_tinymce_toggle_toolbar = $("#pref_tinymce_toggle_toolbar").val() == '1' ? true : false;

    /* timnymce ------------------------------------------------------------------*/
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
                var do_nothing = 0;
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


    /* tools -----------------------------------------------------------------*/
    $("#btn_save").button({
        icons: {
            primary: 'ui-icon-check'
        }
    });

    $('#btn_save').click(function () {
        save_page_version();
    });

    $("#date_publish_start").datetimepicker(
        {
            dateFormat: dateformat,
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
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true
        },
        $.datepicker.regional[ lang ],
        $.timepicker.regional[ lang ]
    );

    load_page_version();

    $('legend').siblings().hide();

    $('legend').click(function () {
        $(this).siblings().slideToggle("slow");
    });

});


function load_page_version() {

    var project_url = $("#project_url", window.opener.document).val();

    // load content to tinymce
    $.ajax({
        type: 'POST',
        url: project_url + "/app/admin/rte/ajax_load_page_version.php",
        data: {
            date_published: ''
        },
        success: function (data) {

            var j = $.parseJSON(data);
            //console.log(j.html);

            $("#rte").html(j.html);
        }
    });

}


function save_page_version() {
    update_user_message('Saving...');
}


function update_user_message(msg) {
    $("#user_message").jui_alert({
        message: msg
    });
}