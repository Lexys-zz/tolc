var ezDialogue = {
     init : function () {
          // remove tinymce stylesheet.
        var allLinks = document.getElementsByTagName("link");
        allLinks[allLinks.length-1].parentNode.removeChild(allLinks[allLinks.length-1]);
    },
     fileSubmit : function (FileURL) {
       //alert(FileURL)
        var URL = FileURL;
                 try
  {
        var win = tinyMCEPopup.getWindowArg("window");
        }
        catch(err){ alert('Error: Cannot insert\n\"tiny_mce_popup.js\" URL in ezfilemanager/index.php line 23 is wrong');return false;}
        // insert information now
        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;

        // for image browsers: update image dimensions
		  if (document.URL.indexOf('type=image') != -1 || document.URL.indexOf('type=all') != -1)
			  {
                 try
  {
	        if (win.ImageDialog.getImageData) win.ImageDialog.getImageData();
	        if (win.ImageDialog.showPreviewImage) win.ImageDialog.showPreviewImage(URL);
  }
  catch(err){}
			  }
        // close ppup window
        tinyMCEPopup.close();
    }
}
  try
  {
tinyMCEPopup.onInit.add(ezDialogue.init, ezDialogue);
 }
  catch(err){}

function linkinsert(fileurl)
{
     fileName = decodeURI(fileurl);
     $(opener.document.getElementById(window.name)).val(fileName);
     self.close()
}