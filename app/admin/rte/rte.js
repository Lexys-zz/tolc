$(function () {

    var tinymce_url = $("#tinymce_url", window.opener.document).val();
    var ezfilemanager_url = $("#ezfilemanager_url", window.opener.document).val();
    var content_css_url = $("#content_css_url", window.opener.document).val();
    var lang = $("#lang", window.opener.document).val();
    var rte_content = $("#rte_content", window.opener.document).val();
    var base_url = $("#base_url", window.opener.document).val();

    $("#rte").tinymce({
        // Location of TinyMCE script
        script_url: tinymce_url,

        // General options
        theme: "advanced",
        plugins: "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,ezfilemanager",
        language: lang,
        entity_encoding: "raw",
        relative_urls: true,
        document_base_url: base_url,

        // Theme options
        theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor",
        theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview",
        theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,fullscreen|nonbreaking,pagebreak",
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

});