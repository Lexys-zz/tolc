/**
 * Opens window screen centered.
 * @param windowWidth the window width in pixels (integer)
 * @param windowHeight the window height in pixels (integer)
 * @param windowOuterHeight the window outer height in pixels (integer)
 * @param url the url to open
 * @param wname the name of the window
 * @param features the features except width and height (status, toolbar, location, menubar, directories, resizable, scrollbars)
 */
function CenterWindow(windowWidth, windowHeight, windowOuterHeight, url, wname, features) {
    var centerLeft = parseInt((window.screen.availWidth - windowWidth) / 2);
    var centerTop = parseInt(((window.screen.availHeight - windowHeight) / 2) - windowOuterHeight);

    var misc_features;
    if (features) {
        misc_features = ', ' + features;
    }
    else {
        misc_features = ', status=no, location=no, scrollbars=yes, resizable=yes';
    }
    var windowFeatures = 'width=' + windowWidth + ',height=' + windowHeight + ',left=' + centerLeft + ',top=' + centerTop + misc_features;
    var win = window.open(url, wname, windowFeatures);
    win.focus();
    return win;
}

/**
 * Escapes special characters for Javascript regex
 * http://simonwillison.net/2006/Jan/20/escape/#p-6
 *
 * Alternative syntax:
 * return text.replace(/[-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
 * return text.replace(/([.*+?^$|(){}\[\]])/mg, "\\$1");
 *
 * @param text
 * @return {*}
 */
function escapeRegexJS(text) {
    return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
}

