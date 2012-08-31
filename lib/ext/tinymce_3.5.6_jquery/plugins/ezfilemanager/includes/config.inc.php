<?php
    /**
        * Eazy file manager platform for TinyMCE
        * ezFilemanager v2.1.1c final 08-03-2010
        * @author Nazaret Armenagian (Naz)
        * @link www.webnaz.net
        * @since August-2008
        * Usual and unnecessary GNU General Public License should follow
    */
    /**
        * Define lang (translate langs/en.inc.php for other langs)
	* Default en
	* Define Paths and URL
	* Enable-disable check for directory permisions
	* Enable-disable delete/rename/upload
	* Define valid characters in URL (hack_block), no need to modify unless you
	* know what you are doing
	* Define thumb creation/max simultaneous uploads, file size etc
	* Some other definitions, date, chop long names etc
    */
    /** set_time_limit(20*60)
        * Uncomment to set script time out if you wish
        * This might not work if it's more than the default PHP max_execution_time,
        * you might be able to use php.ini or htaccess file
        * but check with your hosting provider for info
        * use echo ini_get('max_execution_time') to see your default exec. time
        * but some hosts disable ini_get
        * read more http://www.php.net/manual/en/ini.php
    */
/** CONFIGURE BELOW **/
error_reporting(E_ALL);//Change to error_reporting(0) for live sites
    //@set_time_limit(20*60); // 20 minutes execution time
    define('LOGIN_FORM',false);//Enable authentication (true/false)
    define('ENABLE_FORM_TOKEN','1');//Enable form token (true/false
    define('KEY_1','guitars_hard_rock'); //ANY SECRET KEY, needed if ENABLE_FORM_TOKEN=TRUE
    define('KEY_2','smoke_on_the_water'); //ANY SECRET KEY, needed if ENABLE_FORM_TOKEN=TRUE
    define('SECRET','remember security, never trust user input');//ANY SECRET STRING, needed if ENABLE_FORM_TOKEN=TRUE
    define('AUTHENTICATION_SESSION_NAME','user_id');//Session name to use
    define('USER','admin'); //Username
    define('PASSWORD','demo');//Password
    define('LANG',substr($_SESSION['locale'],0,2));//en,nl,de see langs folder
    define('USER_DIR','');//for multiuser directories, implementation is up to you, trailing slash required, leave empty for single user
    define("UPLOAD_DIR",UPLOADS_URL . ($lk_roles_id == CONST_ROLE_ADMIN_KEY ? '' : 'files/'));//upload directory relative to your document root directory, trailing slash required
    define("SITE_URL",CONST_PROJECT_FULL_URL);
	define('ABSOLUT_PATH', $tolc_conf['project_dir']);
/* OPTIONAL SWITCHES */
    define('IMAGE_FILES','png,jpg,jpeg,gif');//allowed image files extensions
    define('MEDIA_FILES','swf,flv,mp3,mp4,mov,avi,mpg,qt');//allowed meadia files extensions
    define('OTHER_FILES','html,pdf,ppt,txt,doc,docx,odt,xls,xlsx,ods,rtf,xml,xsl,dtd,zip,7z,gz,rar');//allowed other files extensions
    define('DATE_FORMAT','M d Y H:i');//http://php.net/manual/en/function.date.php
    define('KEEP_COPY','120');//seconds, how long to keep copy in memory
    define('ENABLE_DELETE',in_array($lk_roles_id, array(CONST_ROLE_ADMIN_KEY, CONST_ROLE_EDITOR_KEY)));//allow file/dir deleting  (true/false)
    define('ENABLE_RENAME',in_array($lk_roles_id, array(CONST_ROLE_ADMIN_KEY, CONST_ROLE_EDITOR_KEY)));//allow file/dir renaming  (true/false)
    define('ENABLE_COPY',in_array($lk_roles_id, array(CONST_ROLE_ADMIN_KEY, CONST_ROLE_EDITOR_KEY)));//allow file copy  (true/false)
    define('ENABLE_NEW_DIR',true);//allow new dir creation  (true/false)
    define('CHECK_IF_WRITABLE',true); //do checks to see if dir is writable (true/false)
    define('PRESERVE_CASE',false);//If false, new files/dirs will be converted to lowercase
    define('ALLOW_SPACE',false);//Allow space in file/folder names
    define('PREVIEW_IMAGE_ENABLE',true); /* Disable/enable image mouse-over preview (true/false) */
    define('PREVIEW_ON_THE_FLY',false); /* Create on the fly image mouse-over preview, faster but you might have PHP memory issues with very large or high DPI images (true/false) */
    define('PREVIEW_SIZE',150);//Files with more than xxx width or height, will be resized proportionally
    define('THUMB_ENABLE',true);//Allow thumb creation  (true/false)
    define('THUMB_NEW_FOLDER',true);//if true thumb will be created in folder THUMB_PREFIX-filename
    define('THUMB_PREFIX','thumb');//prefix of the thumb folder or file if THUMB_NEW_FOLDER is false
    define('MAX_SIM_UPLOAD','4');  //Max number of simultaneous uploads, 0 disables upload
    define('CUSTOM_MAX_UPLOAD_SIZE','10485760');//0 to use server default or custom size in bytes 1048576=1M
    define('TRUNCATE_FILE','0');// Truncate large file names to xx chars, 0 to disable
    define('RELOAD_PAGE','2');//x Seconds, reload page after upload/directory creation
    define('DIR_INDEXING','index.html');//empty/filename, if "filename", "filename" will be created in new directories
    define('HIDE_FILES','index.html');// hide files from filebrowser, seperated with comma, e.g DIR_INDEXING file or home.html,default.php
    define("BRANDING",true);//enable header branding (true/false) see css/branding folder
    define('JW_PLAYER_ENABLE',true);//enable JW Player  (true/false) www.longtailvideo.com
    define('JW_PLAYER_FILES','mp3,mp4,flv,jpg,jpeg,gif,png');//Files supported by JW Player  
    define('JW_PLAYER_AUTOSTART',false);//Start JW Player on load  (true/false)
    define('KB','KiB');//KiB or Kb http://en.wikipedia.org/wiki/Kibibyte
    define('MB','MB');//MiB or MB http://en.wikipedia.org/wiki/Kibibyte
    define('HACK_PATH_CHAR','/[;\\\\\\.&,:$><]/i');//no need to modify unless you know what you are doing
    define('EZ_VERSION','v2.5');

?>