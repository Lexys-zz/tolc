function CustomFileBrowser(field_name, url, type, win) {
//Your ezfilemanager path might be different, change it accordingly
var cmsURL = "http://"+document.domain+"/tinymce/jscripts/tiny_mce/plugins/ezfilemanager/index.php";
    cmsURL = cmsURL + "?type=" + type + "&tmce=1";

    tinyMCE.activeEditor.windowManager.open({
        file: cmsURL,
        width: 720,  // Your dimensions may differ - play with them, but dont forget the css!
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
