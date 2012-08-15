$(function () {
    var project_url = $("#project_url", window.opener.document).val();
    var tinymce_url = $("#tinymce_url", window.opener.document).val();
    var ezfilemanager_url = $("#ezfilemanager_url", window.opener.document).val();
    var content_css_url = $("#content_css_url", window.opener.document).val();
    var lang = $("#lang", window.opener.document).val();
    var rte_content = $("#rte_content", window.opener.document).val();
    var base_url = $("#base_url", window.opener.document).val();

    /* timnymce ------------------------------------------------------------------*/
    $("#rte").tinymce({
        // Location of TinyMCE script
        script_url: tinymce_url,

        // General options
        theme: "advanced",
        plugins: "lists,advlist,style,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,media,searchreplace,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template,ezfilemanager",
        language: lang,
        entity_encoding: "raw",
        relative_urls: true, // default
        document_base_url: base_url,

        // Theme options
        theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor",
        theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime",
        theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,fullscreen|nonbreaking",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,

        // Example content CSS (should be your site CSS)
        content_css: content_css_url,

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


    // load content to tinymce
    $.ajax({
        type: 'POST',
        url: project_url + "/app/admin/rte/ajax_load_content.php",
        data: {
            date_published: ''
        },
        success: function (data) {
            $("#rte").html(data);
        }
    });


    /* tools -----------------------------------------------------------------*/
    $("#btn_save").button({
        icons: {
            primary: 'ui-icon-check'
        }
    });


});