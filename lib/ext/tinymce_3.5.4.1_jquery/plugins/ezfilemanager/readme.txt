Eazy file manager platform for TinyMCE or stand-alone file management utility.

@ezFilemanager v2.5 release 07-02-2011
@author Webnaz Creations (Naz)
@link www.webnaz.net

Usual and unnecessary GNU General Public License should follow.  
If you want to be the first to read the License, see <http://www.gnu.org/licenses/>.
But please report any security issues asap.


ezFilemanager v2.5 features:
==========================
- It is an online file management utility
- It can be installed as stand-alone file management system
- It can be used as text input field plugin
- Simple Authentication method
- Integrates with TinyMCE as Plugin.
- Integrates as a custom file browser within TinyMCE for image, media and link popup.
- Browse directories.
- Preview files
- Download files
- Rename files and/or directories
- Delete files (single/multiple).
- Delete Directories (even non empty).
- Upload files (based on type permission for image/media/other).
- Upload dynamicaly multiple files simultaneously
- Rename files before uploading
- Enable/Disable file/directory delete
- Enable/Disable file/directory rename
- Enable/Disable file upload
- Check if directory is writable
- Create multiple  Directories simultaneously
- Restrict max upload size for files.
- Restrict characters to use for uploaded files and new Directories.
- Multilingual.(English, Dutch, German, Norwegian, Portuguese, Spanish, Swedish, Czech)
- Security to block non existant folders and back_browsing (../../etc).
- Some other user definable settings, see includes/config.inc.php.
- Almost every single function is fully commented and dated


Version Notes
=============
v2.5 final 07-02-2011
   Added simple authentication method
   Added custom plugin for inserting links in text input fields
   Minor security bug fixes
   
v2.1.1d final 01-07-2010
   Added Spanish translation (by Pablo Muñoz)
   Added Swedish translation (by Jan Forsman)
   Added Czech translation (by Karel Korous)

v2.1.1c final 08-03-2010
   Fixed delete file/folder javascript error
   Added Portuguese translation (by Anderson)

v2.1.1b final 14-02-2010
   Added Norwegian translation (by Ole Harald)

v2.1.1a final 09-02-2010
   Fixed check writable typo which returned false for Win OS

v2.1.1 final 03-02-2010
   Added option to enable/disable thumb creation
   Added option to enable/disable copy/paste
   Fixed image preview typo
   Changed some definitions to more meaningful text
   
v2.1 final 02-02-2010
   Changed ezFilemanager php functions to class
   Changed ezFilemanager folder read function
   Changed ezFilemanger config allowed file types
   Fixed copy/paste not working with IE when spaces in folder/file
   Fixed copy/paste/upload/rename not keeping file extension character case
   Added ezFilemanager folder navigation function
   Added better upload error handeling
   Added option to disable image mouse-over preview
   Added JW-Player to media files (www.longtailvideo.com)
   Added toggle (hide/show) link to directory information
   Added Dutch translation (by Peter Bakker)
   Added German translation (by Herbert Weissenboek))
   Removed breadcrumbs.inc.php
   Removed upload_path/dir_path hidden form fields for better security
   
v2.0.1a final 21-01-2010
   Fixed Image Preview javascript not returning correct this.href
   Fixed PHP get_file_mime function for unknown file types
   Changed Insert Image/File link (Tiny_MCE) javascript

v2.0.1 final 18-01-2010
   Fixed DOCUMENT_ROOT ending slash problem
   Fixed right click context menu delete function
   Fixed file renaming not updating correctly in memory file to copy (if it exists)
   Fixed file upload function not verifying upload directory
   Fixed folder creation function not verifying directory in which the new folder will be created
   Changed PHP htmlspecialchars_decode to javascript
   Added option to allow/disallow spaces in file/folder names (config)
   Added security/sanitation to file/folder deleting function
   Added javascript checking for tiny_mce_popup.js correct URL
   Removed file/folder renaming disabling delete checkbox
   Compressed js files
    
v2.0 final 12-01-2010
   Fixed CSS compatibilty with major browsers
   Fixed ezFilebrowser showing hidden linux directories
   Added right click download,copy,paste and delete context menu
   Added file copy/paste between directories

see change_log.txt for complete version changes

Installation
============
Copy the ezFilemanager folder and contents to your TinyMCE plugins directory.

1) Stand alone installation
   Open config.inc.php and edit configuration, mainly the UPLOAD_DIR
   Just point your browser to the ezfilemanager folder
2) Plugin Installation within TinyMCE
Open config.inc.php and edit configuration, mainly the UPLOAD_DIR
You have to edit 3 pages, ezfilemanager/index.php, ezfilemanager/js/ez_tinyMCE.js and your page containig tiny_mce

a) index.php
	Open ezfilemanager/index.php
	Set the path of <script src="YOUR-URL-PATH-TO/tiny_mce_popup.js" type="text/javascript"></script>

b) ez_tinyMCE.js
	Open js/ez_tinyMCE.js and edit var cmsURL ="..."
	var cmsURL = "http://"+document.domain+"/YOUR-PATH-TO/plugins/ezfilemanager/index.php";

c) Your page containing the tiny_mce editor
	Add ez_tinyMCE.js to your tiny_mce page, make sure the path is correct
	<script type="text/javascript" src="your-path/tiny_mce.js"></script>//This allready exits
	<script src="YOUR-PATH-TO/plugins/ezfilemanager/js/ez_tinyMCE.js" type="text/javascript"></script>//Add this

Add plugin to TinyMCE plugin option list. example: plugins : "ezfilemanager". 
Add the button, example: theme_advanced_buttons3 : "ezfilemanager".
After your buttons, add file_browser_callback: "CustomFileBrowser",
Example snippet
in your TinyMCE init:
	tinyMCE.init({
		mode : 'textareas',
		theme : 'advanced',
		plugins : "ezfilemanager,.......",
		theme_advanced_buttons3_add_before : 'separator,ezfilemanager',
		relative_urls : false,
		file_browser_callback: "CustomFileBrowser",
		..........
	});


Generic Plugin for text input area.
===================================
Put this in your page <head></head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<!-- modify according to your directory structure -->
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/plugins/ezfilemanager/js/ez_plugin.js"></script>

Open ez_plugin.js and make sure the URL of "var newWindow" is correct
Put text input in the page, give a unique ID to the input (You can have multiple text inputs if you wish to)
<input type="text" name="title" id="myid" value=""  />
Double clicking the text input field will open ezfilemanager
if you want to open a specific directory then use the custom "dir" attribute
<input type="text" name="title" id="myid" dir="media/myfolder/" value=""  />

This is it, let me know if you have any problems