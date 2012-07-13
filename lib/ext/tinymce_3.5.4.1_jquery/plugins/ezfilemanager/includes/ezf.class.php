<?php
if(function_exists("date_default_timezone_set") && function_exists("date_default_timezone_get")){
@date_default_timezone_set(@date_default_timezone_get());
}
(isset($_GET['p']) && $_GET['p'] !="") ? define("MEDIA_PATH",ABSOLUT_PATH.$_GET['p']) : define("MEDIA_PATH",ABSOLUT_PATH.UPLOAD_DIR);
(isset($_GET['p']) && $_GET['p'] !="") ? define("CURRENT_PATH",$_GET['p']) : define("CURRENT_PATH",UPLOAD_DIR);
(isset($_GET['type'])) ? $active_type=$_GET['type'] : $active_type='all';
/********
	 * $Id: ezFilemanager helper class 25-01-2010 Naz $
	 * ezHelpers ezFilemanager Class
	 * 
*********/
class ezHelpers {
/********
        * $Id: login  07-02-2011 Naz $
        * Check if authentication is enabled
        * If enabled, include login form
        */    
    
    function login(){
    if (LOGIN_FORM){
    
    include('login.inc.php');
   

}
if (isset($_GET['logout'])){
    unset($_SESSION[AUTHENTICATION_SESSION_NAME]);
     if (substr($_SERVER['HTTP_HOST'],-1)=='/'){
         $_SERVER['HTTP_HOST'] = substr($_SERVER['HTTP_HOST'],0,-1);
        }
     $query_string="";
    if (isset($_GET['tmce'])){
    $query_string="?tmce=".$_GET['tmce'];
    }
     header("Location:http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']. $query_string);
}
    }
/********
        * $Id: authenticate  07-02-2011 Naz $
        * Check if useername/password is correct
        * If correct, create the session
        * You can change it to use database,flat file etc
        */    
    
    function authenticate(){
    //Put your custom verification code here
    if (trim($_POST['username']) ==USER && trim($_POST['password'])==PASSWORD){
     $_SESSION[AUTHENTICATION_SESSION_NAME]=1;
     if (substr($_SERVER['HTTP_HOST'],-1)=='/'){
         $_SERVER['HTTP_HOST'] = substr($_SERVER['HTTP_HOST'],0,-1);
        }
        header("Location:http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
    
    }
    }
/********
        * $Id: get_extension  12-10-2009 Naz $
        * Get file extension and
        * return the extension
        */
function get_extension($file){
    return strtolower(substr($file, strrpos($file, '.') + 1));
}
/********
        * $Id: get_raw_extension  30-01-2010 Naz $
        * Get file extension without converting to lowercase
        * return the extension as it is
        */
function get_raw_extension($file){
    return substr($file, strrpos($file, '.') + 1);
}
/********
        * $Id: strip_extension  12-10-2009 Naz $
        * Strip the file extension and
        * return the filename without the extension
        */
function strip_extension($file){
  return substr($file, 0, strrpos($file, '.'));
}
/********
        * $Id: filter_by  12-10-2009 Naz $
        * Filter for file type view
        */
function filter_by(){
    return  $filter_by = array('all','image','media','file');
}
/********
        * $Id: filter_by_lng  12-10-2009 Naz $
        * Filter language translation for file type view
        */
function filter_by_lng(){
    return  $filter_by_lng = array('all'=> TXT_ALL,'media'=>TXT_MEDIA,'file'=>TXT_FILE,'image'=>TXT_IMAGE);
}
/********
        * $Id: sort_case  12-10-2009 Naz $
        * Sort file list taking into consideration character case
        */
static function sort_case($a, $b){
    if (strtolower($a) == strtolower($b)) {
        return 0;
    }
    return (strtolower($a) < strtolower($b)) ? -1 : 1;
}
/********
        * $Id: ezf_file_type_show  12-10-2009 Naz $
        * Returns what filetype to show of the
        * ezfilemanager filetype multidimensional array
        */    
function ezf_file_type_show(){
    $this->file_type= $this->ezf_file_extensions();
    (isset($_GET['type'])) ? $this->filetype=$this->file_type['filetype'][$_GET['type']] : $this->filetype=$this->file_type['filetype']['all'];
    return $this->filetype;
}
/********
        * $Id: ezf_file_extensions  12-10-2009 Naz $
        * Returns ezfilemanager filetype multidimensional array
        */ 
function ezf_file_extensions(){
    $this->ezfilemanager = array();
    $this->ezfilemanager['filetype']['media'] =  explode(',',MEDIA_FILES);
    $this->ezfilemanager['filetype']['file']  =  explode(',',OTHER_FILES);
    $this->ezfilemanager['filetype']['image'] =  explode(',',IMAGE_FILES);
    $this->ezfilemanager['filetype']['all'] =  array_merge($this->ezfilemanager['filetype']['media'],$this->ezfilemanager['filetype']['file'],$this->ezfilemanager['filetype']['image']);
    return $this->ezfilemanager;
}
/********
        * $Id: file_info  12-10-2009 Naz $
        * Returns ezf_file_types multidimensional array
        * used in get_file_information
        */ 
function file_info(){
    $this->ezf_file_types = array(
    array(array("exe", "com"), "exe.gif", "exe", "popup"),
    array(array("zip", "gzip", "rar", "gz", "tar"), "archive.gif", "archive", "popup"),
    array(array("htm", "html", "php", "jsp", "asp"), "html.gif", "html", "popup"),
    array(array("mov", "mpg", "avi", "asf", "mpeg", "wmv","mp4","qt"), "movie.gif", "movie", "popup"),
    array(array("aif", "aiff", "wav", "mp3"), "audio.gif", "sound", "popup"),
    array(array("swf","flv"), "swf.gif", "Flash file", "popup"),
    array(array("ppt", "pps"), "powerpoint.gif", "powerpoint", "popup"),
    array(array("rtf"), "rtf.gif", "document", "popup"),
    array(array("css"), "css.gif", "css", "popup"),
    array(array("js", "json"), "script.gif", "script", "popup"),
    array(array("doc"), "word.gif", "word", "popup",),
    array(array("pdf"), "pdf.gif", "pdf", "popup"),
    array(array("xls"), "excel.gif", "excel", "popup"),
    array(array("txt"), "txt.gif", "txt", "popup"),
    array(array("xml", "xsl", "dtd"), "xml.gif", "xml", "popup"),
    array(array("gif", "jpg", "jpeg", "png", "bmp", "tif"), "image.gif", "image", "preview")
        );
     return $this->ezf_file_types;
}
/********
        * $Id: get_file_information  12-10-2009 Naz $
        * Returns ezf_file_types multidimensional array
        * For file icons
        */ 
function get_file_information($file) {
    $this->height=false;
    $this->width = PREVIEW_SIZE;
    $this->file_size = $this->bytestostring(filesize(MEDIA_PATH.$file));
    $this->file_date = date(DATE_FORMAT, filemtime(MEDIA_PATH.$file));
    $this->file_type= $this->ezf_file_extensions();
     if(in_array($this->get_extension($file), $this->file_type['filetype']['image'])){
      
    $this->filename = MEDIA_PATH.$file;
    $this->fileinfo =getimagesize($this->filename);
    list($width_orig, $height_orig) = $this->fileinfo;
    $this->new_size=array();
    $this->new_size=$this->resize_proportional($width_orig,$height_orig);
    $this->width = $this->new_size[0];
    $this->height = $this->new_size[1];
    }
    // Match file extension with icon, type , preview and height (if image)
    foreach ($this->file_info() as $this->type) {
            foreach ($this->type[0] as $this->the_extension) {
                    if ($this->get_extension($file) == $this->the_extension)
                            return array("icon" => $this->type[1], "type" => $this->type[2], "class" => $this->type[3],"dimension"=>$this->width."_".$this->height, "filesize"=>$this->file_size, "file_date"=>$this->file_date);
            }
    }
    // If it is not in our $ezfilemanager_mime_types array
    return array("icon" => "unknown.gif", "type" => "Unknown", "class" => false,"dimension"=>false, "filesize"=>$this->file_size, "file_date"=>$this->file_date);
}
/********
        * $Id: resize_proportional  12-10-2009 Naz $
        * calculates the proportional resized images
        * width and height based on PREVIEW_SIZE
        * in config
        */
function resize_proportional($width,$height){
    $this->new_size = array();
    $this->ratio = $width/$height;
    if ($width  <= PREVIEW_SIZE && $height<=PREVIEW_SIZE){
        $this->new_size[0]=$width;
        $this->new_size[1]=$height;
        return $this->new_size;
    }else{
        if ($this->ratio  > 1) {
            $this->nheight = floor(($height*PREVIEW_SIZE)/$width);
            $this->nwidth = PREVIEW_SIZE;
        }else{
        $this->nheight = PREVIEW_SIZE;
        $this->nwidth = floor(($width*PREVIEW_SIZE)/$height);
        }
    }
    $this->resize_proportional($this->nwidth,$this->nheight);
    $this->new_size[0]=$this->nwidth;
    $this->new_size[1]=$this->nheight;
    return $this->new_size;
}
/********
	 * $Id: bytestostring 011 18-08-2008 Naz $
	 * Crude and dirty bites conversion to KB or MB
	*/
function bytestostring($size, $precision = 2) {
    if ($size <= 0){
        return "0 ".KB; //just play it safe
    }elseif ($size < 1048576){//if smaller than 1MiB
        return number_format($size/1024, $precision)." ".KB;
    }else{
        return number_format($size/1048576, $precision)." ".MB;
    }
}
/********
	 * $Id: return_bytes 04-01-2010 Naz $
	 * Read php.ini settings e.g. ini_get('upload_max_filesize')
	 * and convert to bytes
	*/
function return_bytes($val) {
    $this->val = trim($val);
    $this->last = strtolower($this->val[strlen($this->val)-1]);
        switch($this->last) {
        case 'g':
            $this->val *= 1024;
        case 'm':
            $this->val *= 1024;
        case 'k':
            $this->val *= 1024;
    }
    return $this->val;
}
/********
	 * $Id: check_post_data 01-02-2010 Naz $
	 * check if POST exceeds PHP post_max_size
	 * and show error
	 * 
	*/
function check_post_data(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) && $_SERVER['CONTENT_LENGTH'] > 0) {
        die("<div id='error'>".TXT_ERROR." POST data (".$this->bytestostring($_SERVER['CONTENT_LENGTH']).")</div>");
    }

}
/********
	 * $Id: make_protected_filearray 05-01-2010 Naz $
	 * read HIDE_FILES from config
	 * and prepare an array
	 * 
	*/
function make_protected_filearray(){
    $this->protected_array = explode(",",HIDE_FILES);
    return  $this->protected_array;
}
    
/********
	 * $Id: make_thumb 05-01-2010 Naz $
	 * for mouseover thumb on the fly image preview
	 * 
	*/
function make_thumb($file){
    $this->width = PREVIEW_SIZE;
    $this->height = PREVIEW_SIZE;
    if (!file_exists(ABSOLUT_PATH.$file) || strlen($file)<=5){//IF ERRORS IN IMG OR DIR
    die();
    }
    $this->filename = ABSOLUT_PATH.$file;
    $this->fileinfo =getimagesize($this->filename);
    $this->file_ext=$this->get_extension($this->filename);
    $this->new_size = array();
    header("Content-type: {$this->fileinfo['mime']}");
    list($width_orig, $height_orig) = $this->fileinfo;
    $this->new_size=$this->resize_proportional($width_orig,$height_orig);
    $this->new_width = $this->new_size[0];
    $this->new_height = $this->new_size[1];
    $this->temp_img = imagecreatetruecolor($this->new_width, $this->new_height);
    switch ($this->file_ext) {
    case "gif":
        $this->image = @imagecreatefromgif($this->filename);
        imagecopyresampled($this->temp_img, $this->image, 0, 0, 0, 0, $this->new_width, $this->new_height, $width_orig, $height_orig);
        imagegif($this->temp_img, null, 50);
        imagedestroy($this->image);
        imagedestroy($this->temp_img);
        break;
    case "jpg":
        $this->image = @imagecreatefromjpeg($this->filename);
        imagecopyresampled($this->temp_img, $this->image, 0, 0, 0, 0, $this->new_width, $this->new_height, $width_orig, $height_orig);
        imagejpeg($this->temp_img, null, 50);
        imagedestroy($this->image);
        imagedestroy($this->temp_img);
        break;
    case "jpeg":
        $this->image = @imagecreatefromjpeg($this->filename);
        imagecopyresampled($this->temp_img, $this->image, 0, 0, 0, 0, $this->new_width, $this->new_height, $width_orig, $height_orig);
        imagejpeg($this->temp_img, null, 50);
        imagedestroy($this->image);
        imagedestroy($this->temp_img);
        break;
    case "png":
        $this->image = imagecreatefrompng($this->filename);
        imagecopyresampled($this->temp_img, $this->image, 0, 0, 0, 0, $this->new_width, $this->new_height, $width_orig, $height_orig);
        imagepng($this->temp_img, null, 5);
        imagedestroy($this->image);
        imagedestroy($this->temp_img);
        break;
    }

}
/********
	 * $Id: make_save_thumb 06-01-2010 Naz $
	 * Resize, rename and create image thumb
	 * save as filename-xxx-xxx.ext
	 * PHP memory issues with large or high DPI images
	*/
function make_image_thumb(){
    if (isset($_POST["mst"])){
        if (isset($_POST["width"]) && $_POST["width"] >=1){   
            $this->width = $_POST["width"];
        }else{
        $this->width = PREVIEW_SIZE;  
        }
        if (!file_exists(ABSOLUT_PATH.$_POST["thumb_path"].$_POST["mst"]) || strlen($_POST["mst"])<=5){
            die(TXT_ERROR);//IF ERRORS IN IMG OR DIR
        }
        $this->filename = ABSOLUT_PATH.$_POST["thumb_path"].$_POST["mst"];
        $this->fileinfo =getimagesize($this->filename);
        $this->file_ext=$this->get_extension($this->filename);
        list($width_orig, $height_orig) = $this->fileinfo;
        $this->ratio = $this->width/$width_orig;
        if ($width_orig  > $this->width) {
            $this->height = floor($height_orig*$this->ratio);
        }else{
            $this->height = $height_orig;
            $this->width = $width_orig;
        }
        $this->tmp_name = $this->strip_extension($_POST["mst"]);
        if (THUMB_NEW_FOLDER){
            $this->tmp_directory =ABSOLUT_PATH.$_POST["thumb_path"].THUMB_PREFIX."-".$this->tmp_name;
            $this->new_name = $this->tmp_name."-".$this->width."x".$this->height.".".$this->file_ext;
            if (!is_dir($this->tmp_directory)){
                @mkdir($this->tmp_directory, 0755);
                if (DIR_INDEXING){
                    $this->handle = fopen($this->tmp_directory."/".DIR_INDEXING, "w");
                fclose($this->handle);
                }
            }
        }else{
            $this->tmp_directory =ABSOLUT_PATH.$_POST["thumb_path"];
            $this->new_name = $this->tmp_name."-".THUMB_PREFIX."-".$this->width."x".$this->height.".".$this->file_ext;
        
        }
        $this->new_name = $this->set_filename($this->new_name,".".$this->file_ext,$_POST['thumb_path']);
        $this->temp_img = imagecreatetruecolor($this->width, $this->height);
switch ($this->file_ext) {
    case "gif":
        $this->image = @imagecreatefromgif($this->filename);
        imagecopyresampled($this->temp_img, $this->image, 0, 0, 0, 0, $this->width, $this->height, $width_orig, $height_orig);
        imagegif($this->temp_img, $this->tmp_directory."/".$this->new_name, 100 );
        imagedestroy($this->image);
        imagedestroy($this->temp_img);
        break;
    case "jpg":
        $this->image = @imagecreatefromjpeg($this->filename);
        imagecopyresampled($this->temp_img, $this->image, 0, 0, 0, 0, $this->width, $this->height, $width_orig, $height_orig);
        imagejpeg($this->temp_img, $this->tmp_directory."/".$this->new_name, 100 );
        imagedestroy($this->image);
        imagedestroy($this->temp_img);
        break;
    case "jpeg":
        $this->image = @imagecreatefromjpeg($this->filename);
        imagecopyresampled($this->temp_img, $this->image, 0, 0, 0, 0, $this->width, $this->height, $width_orig, $height_orig);
        imagejpeg($this->temp_img, $this->tmp_directory."/".$this->new_name, 100 );
        imagedestroy($this->image);
        imagedestroy($this->temp_img);
        break;
    case "png":
        $this->image = @imagecreatefrompng($this->filename);
        imagecopyresampled($this->temp_img, $this->image, 0, 0, 0, 0, $this->width, $this->height, $width_orig, $height_orig);
        imagepng($this->temp_img, $this->tmp_directory."/".$this->new_name, 0 );
        imagedestroy($this->image);
        imagedestroy($this->temp_img);;
        break;
    }
    echo "<script type='text/javascript'>window.location.href = window.location;</script>";
    }

}
/********
	 * $Id: get_file_stats 05-01-2010 Naz $
	 * Show file info and create download
	 * when a file icon is clicked
	*/
function get_file_stats(){
    if (isset($_GET['st']))
    {
        $this->current_dir=dirname($_GET['st']);
        //As usual do some validation
        if (!in_array(basename($_GET['st']),$this->make_protected_filearray()))
        {
        if (!$this->check_upload_path($this->current_dir) && file_exists(ABSOLUT_PATH.$_GET['st']) && in_array($this->get_extension( basename($_GET['st'])),$this->ezf_file_type_show()))
        {
            if (isset($_GET['d']))//Force direct download instead of right clicking and using "save as"
            { 
            $this->filename = ABSOLUT_PATH.$_GET['st'];
                if(ini_get('zlib.output_compression'))
                {
                ini_set('zlib.output_compression', 'Off');
                }
            $this->ctype= $this->get_mimetype(basename($_GET['st']));
            header("Pragma: public"); // required
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false); // required for certain browsers
            header("Content-Type: $this->ctype");
            header("Content-Disposition: attachment; filename=".rawurlencode(basename($this->filename)).";" );
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: ".filesize($this->filename));
            readfile("$this->filename");
            exit();
            }
            $this->stat = stat(ABSOLUT_PATH.$_GET['st']);
            $this->image_size='';
            $this->create_thumb=''; 
            if(in_array($this->get_extension(basename($_GET['st'])), $this->ezfilemanager['filetype']['image']) && THUMB_ENABLE==1)
            {
                list($width, $height) = getimagesize(ABSOLUT_PATH.$_GET['st']);
                $this->image_size='<br /><span class="bold">'.TXT_DIMENSION.'</span> '.$width.'px * '.$height.'px';
                if ($this->check_if_writable(ABSOLUT_PATH.$this->current_dir."/")!=1){
                 $this->create_thumb = "<hr /><span class='bold'>".TXT_CREATE_THUMB."</span><form method='post' action=''><input type='hidden' value='makethumb' name='action' /><input type='hidden' value='".basename($_GET['st'])."' name='mst' /><input type='hidden' value='".dirname($_GET['st'])."/' name='thumb_path' />".TXT_WIDTH." <br /><input id='width' name='width' type='text' size='10' class='thumbfieldtext' maxlength='4'  value='".PREVIEW_SIZE."' />
            <input type='submit' value='".TXT_MAKE."'  id='sub' name='sub'  class='ezbutton' title='".TXT_MAKE."' /></form></span>";
            }
            }
            echo "<div style='text-align:right'><a href='#' class='close' title='".TXT_CLOSE."'><span class='red'>X</span></a></div>";
            echo "<span class='bold'>".TXT_FILE_NAME."</span><span class='red'>".basename($_GET['st'])."</span>";
            echo '<br />';
            echo "<span class='bold'>".TXT_SIZE."</span> ".$this->bytestostring($this->stat['size']).$this->image_size;
            echo '<br />';
            echo "<span class='bold'>".TXT_PERMISSION."</span> ".substr(sprintf('%o', fileperms(ABSOLUT_PATH.$_GET['st'])), -4);
            echo '<br />';
            echo "<span class='bold'>".TXT_CREATED."</span>".date(DATE_FORMAT,$this->stat['mtime']);
            echo '<br />';
            echo "<span class='bold'>".TXT_MODIFIED."</span>".date(DATE_FORMAT,$this->stat['ctime']);
          echo "<hr />";
            echo "<a href='?action=info&amp;st=".$_GET['st']."&amp;d=1' title='".TXT_DOWNLOAD." ".basename($_GET['st'])."' class='ezdownload'>".TXT_DOWNLOAD."</a>";
            if (ENABLE_COPY){
            echo "<a href='?action=copy&amp;w=".$_GET['st']."' title='".TXT_COPY." ".basename($_GET['st'])."'  class='ezcopy' onclick='return false;'>".TXT_COPY."</a>".$this->create_thumb;
            }
            echo "<hr />";
            $jw_player=explode(',',JW_PLAYER_FILES);
            if(JW_PLAYER_ENABLE==1 && in_array($this->get_extension(basename($_GET['st'])), $jw_player))
            {
                $jw_height=100;
                if ($this->get_extension(basename($_GET['st']))=='mp3')
                $jw_height=24;
            echo "<script type='text/javascript' src='js/jwplayer/swfobject.js'></script>

<div id='mediaspace'></div>
<script type='text/javascript'>
  var so = new SWFObject('js/jwplayer/player-viral.swf','ply','180','".$jw_height."','9','#ffffff');
  so.addParam('wmode','opaque');
   so.addVariable('autostart','".JW_PLAYER_AUTOSTART."');
  so.addVariable('file','/".$_GET['st']."');
  so.write('mediaspace');
</script>";
            }
           
        }
    }
exit;
    }
}
/********
	 * $Id: delete_directory 12-10-2009 Naz $
	 * Recursively delete directory and content
	 */
function delete_directory($dir) {
    $this->folder=rawurldecode($dir);
    if (substr($this->folder, strlen($this->folder)-1, 1) != '/')
    $this->folder .= '/';
    if ($this->handle = @opendir($this->folder))
        {
            while ($this->obj = readdir($this->handle))
            {
                if ($this->obj != '.' && $this->obj != '..')
                    {
                        if (is_dir($this->folder.$this->obj))
                            {
                                if (!$this->delete_directory($this->folder.$this->obj))
                                return false;
                            }elseif (is_file($this->folder.$this->obj))
                            {
                                @chmod($this->folder.$this->obj, 0777); //remove if you have problems
                                    if (!unlink($this->folder.$this->obj))
                                    return false;
                            }
                    }
                    }
    closedir($this->handle);
    @chmod($dir, 0777);  //remove if you have problems
    if (!@rmdir($dir))
        return false;
    return true;
    }else{
        return true;
        }
}

/********
	 * $Id: basic_hack_block 12-10-2009 Naz $
	 * Make sure GET type is in array
	 * And there are no illigal characters in GET p (path)
	 */
function basic_hack_block(){
   
  if (isset($_GET['type']) && !in_array($_GET['type'],$this->filter_by())){
      die(TXT_TYPE_ERROR);
        }
 if (isset($_GET['p'])){
    if (preg_match(HACK_PATH_CHAR, $_GET['p']) > 0) {
		die(TXT_HACK);
		}
    if (substr($_GET['p'], 0, strlen(UPLOAD_DIR))!= UPLOAD_DIR){
       die(TXT_NOT_ALLOWED);
  		}
 }
    if (isset($_GET['st'])){
    if (substr($_GET['st'], 0, strlen(UPLOAD_DIR))!= UPLOAD_DIR){
       die(TXT_NOT_ALLOWED);
		}
    }
    if (isset($_GET['w'])){
    if (substr($_GET['w'], 0, strlen(UPLOAD_DIR))!= UPLOAD_DIR){
       die(TXT_NOT_ALLOWED);
		}
    }
}
/********
	 * $Id: allow_space 16-01-2010 Naz $
	 * return javascript regex vars
	 * for rename, folder make and upload
	*/
function allow_space($case){
    if (!ALLOW_SPACE){
        switch($case) {
        case 'rename':
       return "value = value.replace(/\s/g, '-');\n";
    break;
    case 'makedir':
       return "dir_to_make = dir_to_make.replace(/\s/g, '-');\n";
    break;
    case 'upload':
       return "uploadfileName = uploadfileName.replace(/\W/g, '-');;\n";
    break;
   
        }
    }
}
/********
	 * $Id: navigation_links 25-01-2010 Naz $
	 * Make directory navigation
	 */
function navigation_links(){
    $this->nav = str_replace(ABSOLUT_PATH.UPLOAD_DIR, "", MEDIA_PATH);
    $this->nav_array=explode("/",$this->nav);
    $this->ez_navigation .= "<a href='?p=".UPLOAD_DIR.$this->type_url()."'>".TXT_HOME."</a> &rsaquo; ";
    $this->folder_name=TXT_HOME; 
    for($x=0; $x<(sizeof($this->nav_array)-1); $x++)
    {
        $this->breadcrumbs .=$this->nav_array[$x]."/";
        $this->ez_navigation .= "<a href='?p=".UPLOAD_DIR.$this->breadcrumbs.$this->type_url()."'>".$this->nav_array[$x]."</a> &rsaquo; ";
        $this->folder_name=$this->nav_array[$x];
    }
    define("CURRENT_FOLDER",$this->folder_name);
    define("CURRENT_URL","?p=".CURRENT_PATH);
    return $this->ez_navigation;
}
/********
	 * $Id: type_url 12-10-2009 Naz $
	 * Append GET type and GET tmce to links
	 */
function type_url(){
  $this->append_url ="";
  if (isset($_GET['type']))
   $this->append_url .="&amp;type=".$_GET['type'];
   $this->append_url .= $this->pop_url();
  return  $this->append_url;

}
/********
	 * $Id: pop_url 12-10-2009 Naz $
	 * Stand alone or TinyMCE popup
	 * Avoid javascript errors
	 */
function pop_url(){
  if (isset($_GET['tmce']))
  return "&amp;tmce=".$_GET['tmce']."";

}
/********
	 * $Id: change_case 29-12-2009 Naz $
	 * Preserve file/dir case or force to lowercase
	 * 
	*/
function change_case($str){
    if (PRESERVE_CASE){
       return $str;
    }else{
        return strtolower($str);
    }
}
/********
	 * $Id: set_max_upload_size 04-01-2010 Naz $
	 * set the max upload file size
	 * either use custom size in config (CUSTOM_MAX_UPLOAD_SIZE) or server default
	*/
function set_max_upload_size(){
    if (CUSTOM_MAX_UPLOAD_SIZE){
    define('MAX_UPLOAD_SIZE',CUSTOM_MAX_UPLOAD_SIZE);
    }else{
        if (!ini_get('upload_max_filesize'))
        {
        die('Cannot autoset upload_max_filesize, please enter CUSTOM_MAX_UPLOAD_SIZE value in config.inc.php');
        }else{
        define('MAX_UPLOAD_SIZE',$this->return_bytes(ini_get('upload_max_filesize')));
        }
    }
}

/********
	 * $Id: do_write_check 012 26-08-2008 Naz $
	 * Return true if the dir is writable
	 */
function do_write_check($dir_to_check) {
    // if windows OS
    // is_writeable does not make a real UID/GID check on Windows.
    $this->folder_to_check = substr($dir_to_check, 0, -1);// remove trailing slash
	if (DIRECTORY_SEPARATOR == "\\")
	    {
		 $this->folder_to_check = str_replace("/", DIRECTORY_SEPARATOR,  $this->folder_to_check);
                if (is_dir($this->folder_to_check))
		    {
			$this->tmp_file = time().md5(uniqid('abcd'));
			if (@touch($this->folder_to_check . '\\' . $this->tmp_file)) {
			    @unlink($this->folder_to_check . '\\' . $this->tmp_file);
			    return true;
			}

		    }
	    return false;
	    }
    // Not windows OS
    return is_writeable($this->folder_to_check);
}
/********
        * $Id: check_if_writable 012 26-08-2008 Naz $
        * check if the working dir is writable
        * If not writable retun error msg
        */
function check_if_writable($dir){
    if (CHECK_IF_WRITABLE){
	if (!$this->do_write_check($dir))
	{
            define('NON_WRITABLE',true);          
	    return true;
	}else{
            define('NON_WRITABLE',false);       
            return false;   
            }
	}
}
/********
	 * $Id: check_upload_path 12-10-2009 Naz $
	 * Make sure the post data is not empty
	 * and also that the directory exists
	*/
function check_upload_path($current_dir){
    if ($current_dir == '')
	{
	    echo "<div id='error'>".TXT_PATH_ERROR."</div>";
	    return TRUE;
	}
        if (! @is_dir(ABSOLUT_PATH.$current_dir)){
            echo "<div id='error'>".TXT_PATH_ERROR."</div>";
	    return TRUE;
        }
    return FALSE;
}
/********
	 * $Id: get_mimetype 04-01-2010 Naz $
	 * Try to get the file mime headers by extension
	 * If not in list use force-download 
	 * 
	*/
function get_mimetype($value='') {
        $this->ct['htm'] = 'text/html';
        $this->ct['html'] = 'text/html';
        $this->ct['txt'] = 'text/plain';
        $this->ct['asc'] = 'text/plain';
        $this->ct['bmp'] = 'image/bmp';
        $this->ct['gif'] = 'image/gif';
        $this->ct['jpeg'] = 'image/jpeg';
        $this->ct['jpg'] = 'image/jpeg';
        $this->ct['jpe'] = 'image/jpeg';
        $this->ct['png'] = 'image/png';
        $this->ct['ico'] = 'image/vnd.microsoft.icon';
        $this->ct['mpeg'] = 'video/mpeg';
        $this->ct['mpg'] = 'video/mpeg';
        $this->ct['mpe'] = 'video/mpeg';
        $this->ct['qt'] = 'video/quicktime';
        $this->ct['mov'] = 'video/quicktime';
        $this->ct['avi']  = 'video/x-msvideo';
        $this->ct['wmv'] = 'video/x-ms-wmv';
        $this->ct['mp2'] = 'audio/mpeg';
        $this->ct['mp3'] = 'audio/mpeg';
        $this->ct['rm'] = 'audio/x-pn-realaudio';
        $this->ct['ram'] = 'audio/x-pn-realaudio';
        $this->ct['rpm'] = 'audio/x-pn-realaudio-plugin';
        $this->ct['ra'] = 'audio/x-realaudio';
        $this->ct['wav'] = 'audio/x-wav';
        $this->ct['css'] = 'text/css';
        $this->ct['zip'] = 'application/zip';
        $this->ct['pdf'] = 'application/pdf';
        $this->ct['doc'] = 'application/msword';
        $this->ct['bin'] = 'application/octet-stream';
        $this->ct['exe'] = 'application/octet-stream';
        $this->ct['class']= 'application/octet-stream';
        $this->ct['dll'] = 'application/octet-stream';
        $this->ct['xls'] = 'application/vnd.ms-excel';
        $this->ct['ppt'] = 'application/vnd.ms-powerpoint';
        $this->ct['wbxml']= 'application/vnd.wap.wbxml';
        $this->ct['wmlc'] = 'application/vnd.wap.wmlc';
        $this->ct['wmlsc']= 'application/vnd.wap.wmlscriptc';
        $this->ct['dvi'] = 'application/x-dvi';
        $this->ct['spl'] = 'application/x-futuresplash';
        $this->ct['gtar'] = 'application/x-gtar';
        $this->ct['gzip'] = 'application/x-gzip';
        $this->ct['js'] = 'application/x-javascript';
        $this->ct['swf'] = 'application/x-shockwave-flash';
        $this->ct['tar'] = 'application/x-tar';
        $this->ct['xhtml']= 'application/xhtml+xml';
        $this->ct['au'] = 'audio/basic';
        $this->ct['snd'] = 'audio/basic';
        $this->ct['midi'] = 'audio/midi';
        $this->ct['mid'] = 'audio/midi';
        $this->ct['m3u'] = 'audio/x-mpegurl';
        $this->ct['tiff'] = 'image/tiff';
        $this->ct['tif'] = 'image/tiff';
        $this->ct['rtf'] = 'text/rtf';
        $this->ct['wml'] = 'text/vnd.wap.wml';
        $this->ct['wmls'] = 'text/vnd.wap.wmlscript';
        $this->ct['xsl'] = 'text/xml';
        $this->ct['xml'] = 'text/xml';
        $this->extension = $this->get_extension($value);
        if (!$this->type = $this->ct[$this->extension]) {
            $this->type = 'application/force-download';
        }
    return $this->type;
}
/********
	 * $Id: santize_name 12-10-2009 Naz $
	 * Although we clean the file/dir name with javascript
	 * Clean the file or directory name for extra security
	 */
function santize_name($filename){
    $this->bad = array(
            "<!--",
            "-->",
            "'",
            "<",
            ">",
            '"',
            '&',
            '$',
            '=',
            ';',
            '?',
            '/',
            '%',
            '[',
            ']',
            '|',
            "%20",
            "%22",
            "%3c",	// <
            "%253c", 	// <
            "%3e", 	// >
            "%0e", 	// >
            "%28", 	// (
            "%29", 	// )
            "%2528", 	// (
            "%26", 	// &
            "%24", 	// $
            "%3f", 	// ?
            "%3b", 	// ;
            "%3d"	// =
            );
    $filename = str_replace($this->bad, '', $filename);
    if (!ALLOW_SPACE){
        $filename = str_replace(" ", "-",$filename);
    }
    return stripslashes($filename);
}
/********
	 *set_filename_length
	 * Limit uploaded file name length
	 * based on TRUNCATE_FILE in config
	 */
function set_filename_length($filename){
    if (TRUNCATE_FILE ==0) //no limit
        {
        return $filename;
        }
    if (strlen($filename) < TRUNCATE_FILE)
        {
        return $filename;
        }

    return substr($filename, 0, TRUNCATE_FILE);
}
/********
	 * Set the new directory name
	 * If exits, it will append a number to the end of the directory name
	 * This will avoid overwriting a pre-existing directory.
	 */
function set_dirname($new_directory,$current_dir){
    if ( !is_dir(ABSOLUT_PATH.$current_dir.$new_directory))
        {
        return $new_directory;
        }
        $this->new_dir_name = '';
        for ($i = 1; $i < 100; $i++)
        {
            if ( !is_dir(ABSOLUT_PATH.$current_dir.$new_directory."-".$i))
            {
                $this->new_dir_name = $new_directory."-".$i;
                break;
            }
        }
    if ($this->new_dir_name == '')
        {
        echo "<div id='error'>".TXT_DIR_EXIST."</div>";
        return FALSE;
        }
        else
        {
        return $this->new_dir_name;
        }
}
/********
	 * Set the new file name
	 * If exits, it will append a number to the end of the file name
	 * This will avoid overwriting a pre-existing file.
	 */
function set_filename($filename,$ext, $filepath){
    if ($filepath==''){
        die("<div id='error'>".TXT_PATH_ERROR."</div>");
    }
    if ( ! file_exists(ABSOLUT_PATH.$filepath.$filename))
	{
	    return $filename;
	}
    $filename = str_replace($ext, '', $filename);
    $this->new_filename = '';
    for ($i = 1; $i < 100; $i++)
	{
	if ( ! file_exists(ABSOLUT_PATH.$filepath.$filename."-".$i.$ext))
	    {
		$this->new_filename = $filename."-".$i.$ext;
		break;
	    }
	}
        if ($this->new_filename == '')
	    {
		echo "<div id='error'>".$filename.": ".TXT_FILE_EXIST."</div>";
		return FALSE;
	    }
	    else
	    {
		return $this->new_filename;
	    }
}
/********
	 * $Id: do_rename 12-10-2009 Naz $
	 * Rename file or directory
	*/
function do_rename(){
    if (isset($_POST['id']))
    {
        $this->insertdata=explode("|",$_POST['id']);
        if ($this->insertdata[3]=='file')//IF we are renaming files
        {
             if (trim($_POST['value'])==''){
                  echo $this->strip_extension($this->insertdata[1]);
                  exit;
                }
            if (in_array($_POST['value'].".".$this->insertdata[2],$this->make_protected_filearray()))
            {
              echo $this->strip_extension($this->insertdata[1]);
              exit;
            }
            $this->tmp_filename = $this->santize_name($_POST['value']);
            $this->new_filename=$this->set_filename($this->change_case($this->set_filename_length($this->tmp_filename)).".".$this->insertdata[2],".".$this->insertdata[2],$this->insertdata[0]);
                        
        if ($this->insertdata[1]!=$this->set_filename_length($this->tmp_filename).".".$this->insertdata[2])
        {
            if (rename(ABSOLUT_PATH.$this->insertdata[0].$this->insertdata[1],ABSOLUT_PATH.$this->insertdata[0].$this->new_filename))
            {
                echo str_replace(".".$this->insertdata[2], '', $this->new_filename);
            }else{
                echo $this->strip_extension($this->insertdata[1]);
            }
        }else{
            echo $_POST['value'];
        }
        }else{ //IF IT IS DIRECTORY
            if ($this->insertdata[1]!=$_POST['value'])
            {
               
                $this->tmp_filename = $this->santize_name($_POST['value']);
                $this->new_directory= $this->set_dirname($this->change_case($this->set_filename_length($this->tmp_filename)),$this->insertdata[0]);//Avoid overwriting
            if (rename(ABSOLUT_PATH.$this->insertdata[0].$this->insertdata[1],ABSOLUT_PATH.$this->insertdata[0].$this->new_directory))
                {
                    echo $this->new_directory;
                }else{
                    echo $this->insertdata[1];
                }
            }else{
                echo $_POST['value'];
            }
        }
    exit;
    }
}
/********
	 * $Id: do_upload 12-10-2009 Naz $
	 * Upload file
	 * Re-sanitize name and avoid overwriting
	*/
function do_upload(){
    if(isset($_POST['upload_now']))
	{
           if (substr(CURRENT_PATH, 0, strlen(UPLOAD_DIR))!= UPLOAD_DIR){
                    die(TXT_NOT_ALLOWED);
                }
        for ($i = 1; $i <= $_POST['numfiles']; $i++)
        {
            if($_FILES["filename".$i.""]["name"])
            {
            $this->uploadFileName="";
            $this->newFileName="";
            $this->ext="";
            $this->uploadFileName = $this->change_case($this->santize_name($_FILES["filename".$i]["name"]));
            $this->newFileLocation = $_FILES["filename".$i.""]["tmp_name"];
            $this->ext= $this->get_extension($this->uploadFileName);
            $this->raw_ext= $this->get_raw_extension($this->uploadFileName);
            //RE-SANITIZE NAME IN CASE OF JAVASCRIPT ERROR
            $this->newFileName = $this->change_case($_POST["newfilename".$i]);
            $this->newFileName = preg_replace("[^A-Za-z0-9 _-]", "", $this->newFileName);
            $this->newFileName = $this->santize_name($this->newFileName);//Better safe than sorry
            //END RE-SANITIZE
            $this->newFileName = $this->set_filename_length($this->newFileName);//Truncate file name length
            if (empty($this->newFileName))continue; //If name exists continue
            if ($this->check_filesize($i)) continue; //If filesize correct continue
            if ($this->checkAllowedType($this->ext,$i)) continue;  //If type correct continue
            if ($this->check_upload_path(CURRENT_PATH)) continue;  //If no upload path hacking attempt continue
            $this->newFileName=$this->set_filename($this->newFileName.".".$this->raw_ext,".".$this->raw_ext,CURRENT_PATH); //Avoid overwriting
            if (@copy($this->newFileLocation,ABSOLUT_PATH.CURRENT_PATH  . $this->newFileName))
            {
                echo "<div id='success'>".$this->newFileName."</div>";
            }else{
            echo "<div id='error'>".TXT_ERROR." ".TXT_MAX_UPLOAD."</div>";
            }
            }else{
                echo "<div id='error'>".TXT_ERROR.": ".$_FILES["file"]["error"]."</div>";
            }
        }
    exit;
        }
}
/********
	 * $Id: check_filesize 12-10-2009 Naz $
	 * Make sure the upload file is within allowed size
	 */
function check_filesize($i){
    if (MAX_UPLOAD_SIZE==0)
	{
        return FALSE;
        }
    if ($_FILES["filename".$i.""]["size"] > MAX_UPLOAD_SIZE)
	{
	echo "<div id='error'>".$_FILES["filename".$i]["name"].": ".TXT_FILE_BIG."<div>";
        return TRUE;
	}
	else
	{
	    return FALSE;
	}
}
/********
	 * $Id: checkAllowedType 013 19-09-2008 Naz $
	 * Check if within allowed upload file types
	 *
	*/
function checkAllowedType($ext,$i){
    $this->ezfilemanager= $this->ezf_file_extensions();
    if(in_array($ext, $this->ezfilemanager['filetype']['all'])){
	return false;
    }else{
	echo "<div id='error'>".$_FILES["filename".$i]["name"].": ".TXT_FILE_INVALID."</div>";
        return TRUE;
    }
}
/********
	 * $Id: do_makedir 12-10-2009 Naz $
	 * Create new directory(s)
	 * Re-sanitize name and avoid overwriting
	*/
function do_makedir(){
   if(isset($_POST['make_dir']))
    {
        if (preg_match(HACK_PATH_CHAR, $_POST['current_dir']) > 0) {
	die(TXT_HACK);
    }
    if (substr($_POST['current_dir'], 0, strlen(UPLOAD_DIR))!= UPLOAD_DIR){
                    die(TXT_NOT_ALLOWED);
                }
    if (isset($_POST['hash']))
    {
        die(TXT_WRONG_KEY);//Blocks direct post, all posts should come from jQuety
    }
        $this->data = array_map('trim', preg_split("|splithere|", $_POST['the_dir'], -1, PREG_SPLIT_NO_EMPTY));
        foreach ($this->data as $this->new_directory)
        {
        //RE-SANITIZE NAME IN CASE OF JAVASCRIPT ERROR
        $this->new_directory = $this->change_case($this->new_directory);
        $this->new_directory = preg_replace("[^A-Za-z0-9 _-]", "", $this->new_directory);
        $this->new_directory = $this->santize_name($this->new_directory);//Better safe than sorry
            if (!empty($this->new_directory))
            {
                $this->new_directory= $this->set_dirname($this->new_directory,$_POST['current_dir']);//Avoid overwriting
                $this->create_directory($this->new_directory);//Now we can create our new directory
            }else{
                echo "<div id='error'>".TXT_ERROR.": ".TXT_DIR_NO."</div>";
            }
        }

    exit;
    }

}
/********
	 * $Id: create_directory 012 26-08-2008 Naz $
	 * If everything OK, try to make the new folder
	 * If failes, probably non writable folder
	 *
	*/
function create_directory($new_directory){
    //die(ABSOLUT_PATH.$_POST['cfolder'].$new_directory);
    if (mkdir(ABSOLUT_PATH.$_POST['current_dir'].$new_directory, 0755))//remove ,0755 if creates problem
	{
	echo "<div id='success'>".$new_directory . " ".TXT_DIR_CREATED."</div>";
        if (DIR_INDEXING){
        $this->handle = fopen(ABSOLUT_PATH.$_POST['current_dir'].$new_directory."/".DIR_INDEXING, "w");
        fclose($this->handle);
        }
	}else{
 	echo "<div id='error'>".TXT_ERROR."</div>";
	}
}
}

/********
	 * $Id: ezFilemanager class 25-01-2010 Naz $
	 * Main ezFilemanager Class
	 * Read Folder and do action (rename,copy,delet,upload etc)
	 * 
*********/
class ezFilemanager extends ezHelpers{
/********
	 * $Id: read_folder 25-01-2010 Naz $
	 * Read the folder and put everything
	 * in a multidimensional array
	 * 
	 */
function read_folder(){
    $this->folder=array();
    $this->files=array();
    $this->current_path=array();
    $this->fileinformation=array();
    $this->folder_date=array();
    $this->size=0;
    $dir_handle = @opendir(MEDIA_PATH) or die("Unable to open ".$_GET['p']);
    $d=$f=0;
    while($file = readdir($dir_handle))
    {
      if ($file != '.' && $file != '..' && !in_array($file,$this->make_protected_filearray()) && $file[0] !='.')
        {
          if (is_dir(MEDIA_PATH.$file)){
            $this->folder[$d]=$file;
            $this->folder_date[$file]= date(DATE_FORMAT, filemtime(MEDIA_PATH.$file));
            $d++;
          }else{
            if(in_array($this->get_extension($file),$this->ezf_file_type_show())){
                $this->fileinformation[$file] =$this->get_file_information($file);
            $this->files[$f]=$file;
            $this->size += filesize(MEDIA_PATH.$file);
            $f++;
          }
        }
      }
    }
    usort($this->files, array(&$this,"sort_case"));
    usort($this->folder, array(&$this,"sort_case"));
    $this->current_path['folder']=$this->folder;
    $this->current_path['file']=$this->files;
    $this->current_path['file_info']=$this->fileinformation;
    $this->current_path['folder_size']=$this->bytestostring($this->size);//$this->size_array;
    $this->current_path['folder_date']=$this->folder_date;
    return $this->current_path;
        }
/********
	 * $Id: ezf_actions 25-01-2010 Naz $
	 * ezfilemanager actions
	 * 
	 */
function ezf_actions(){
    $this->ezaccess=ABSOLUT_PATH.UPLOAD_DIR.".ezaccess";
    $this->action="dummy";//default action
    if (isset($_POST['action']))  $this->action=$_POST['action'];
    if (isset($_GET['action'])) $this->action=$_GET['action'];
    if (isset($_POST['id'])) $this->action='rename';
    switch($this->action) {
    case 'delete': //DELETE FILE FOLDER
        if(isset($_POST['dodelete']) && ENABLE_DELETE==1){
            // Delete any checked files
            if(isset($_POST['delete_file']))
            {
                foreach($_POST['delete_file'] as $file => $val)
                {
                    if (substr($file, 0, strlen(UPLOAD_DIR))!= UPLOAD_DIR){
                        die(TXT_NOT_ALLOWED);
                    }
                if (file_exists(ABSOLUT_PATH.$file))
                    {
                        @chmod(ABSOLUT_PATH.$file, 0777);
                        @unlink(ABSOLUT_PATH.$file);
                    }
                }
                if (file_exists($this->ezaccess)) {
                    @unlink($this->ezaccess);
                }
            }
    // Delete any checked directories and its content
            if(isset($_POST['delete_dir']))
                {
                    foreach($_POST['delete_dir'] as $dir => $val)
                    {
                        if (substr($dir, 0, strlen(UPLOAD_DIR))!= UPLOAD_DIR){
                            die(TXT_NOT_ALLOWED);
                        }
                    $this->delete_directory(ABSOLUT_PATH.$dir);//do the delete_directory recursive del function
                    }
                }
        echo "<script type='text/javascript'>window.location.href = window.location;</script>";
        }//end if(isset($_POST['dodelete']))
        break;
    case 'preview'://MOUSE OVER PREVIEW
        $this->make_thumb($_GET['f']);
        break;
    case 'info'://FILE ICON CLICK FOR INFO
        $this->get_file_stats();
        exit;
        break;
    
    case 'copy': //FILE COPY
        if (ENABLE_COPY){ //prevent bypassing config option
        $this->handle = fopen($this->ezaccess, "w");
            if (!fwrite($this->handle, $_GET['w'])) {
                echo TXT_COPY." ".TXT_ERROR;
            } 
        fclose($this->handle);
        echo TXT_FILETO_COPY."<br /><span class='red'>".rawurldecode(basename($_GET['w']))."</span>";
        exit;
        }
        break;
    case 'paste': //FILE PASTE (Right click)
        if (file_exists($this->ezaccess)) {
                $this->handle = fopen($this->ezaccess, "r");
                $this->output = rawurldecode(fread($this->handle, filesize($this->ezaccess)));
            }else{
                echo TXT_PASTE." ".TXT_ERROR;
                exit;
            }
        $this->ext=$this->get_raw_extension(basename($this->output));
        $this->newfile = basename($this->output);
        $this->newFileName=$this->set_filename($this->newfile,".".$this->ext,$_GET['w']);
        if (!copy(ABSOLUT_PATH.$this->output, ABSOLUT_PATH.$_GET['w'].$this->newFileName)) {
                echo TXT_COPY." ".TXT_ERROR;
                fclose($this->handle);
            @unlink($this->ezaccess);
            exit;
            }
        fclose($this->handle);
        @unlink($this->ezaccess);
        exit;
        break;
    case 'pastehere'://FILE PASTE (Toolbar Icon)
        if (file_exists($this->ezaccess)) {
                $this->handle = fopen($this->ezaccess, "r");
                $this->output = rawurldecode(fread($this->handle, filesize($this->ezaccess)));
            }else{
                echo TXT_PASTE." ".TXT_ERROR;
                exit;
            }
        $this->ext=$this->get_raw_extension(basename($this->output));
        $this->newfile =basename($this->output);
        $this->newFileName=$this->set_filename($this->newfile,".".$this->ext,$_GET['w']);
        if (!copy(ABSOLUT_PATH.$this->output, ABSOLUT_PATH.$_GET['w'].$this->newFileName)) {
                echo TXT_COPY." ".TXT_ERROR;
                fclose($this->handle);
                @unlink($this->ezaccess);
            exit;
            }
        fclose($this->handle);
        @unlink($this->ezaccess);
        exit;
        break;
    case 'cancel': //Cancel PASTE (do we need this?)
        if (file_exists($this->ezaccess)) {
            @unlink($this->ezaccess);
            }
        exit;
        break;
    case 'sdelete': //SIGLE FILE DELETE (Right click)
        if (file_exists(ABSOLUT_PATH.$_GET['w'])) {
            @unlink(ABSOLUT_PATH.$_GET['w']);
                if (file_exists($this->ezaccess)) {
                    $this->handle = fopen($this->ezaccess, "r");
                    $this->output = rawurldecode(fread($this->handle, filesize($this->ezaccess)));
                    if ($this->output ==$_GET['w']){
                        @unlink($this->ezaccess);
                    }
                    fclose($this->handle);
                }
                
            }
        exit;
        break;
    case 'makethumb'; //CREATE IMAGE THUMB FROM FILE INFO BOX
        $this->make_image_thumb();
        exit;
        break;
    case 'rename'; // RENAME FILE FOLDER
        $this->do_rename();
        exit;
        break;
    case 'after_rename': //DELETE ezaccess FILE if file that is renamed is in copy memory
        if (file_exists($this->ezaccess)) {
            $this->handle = fopen($this->ezaccess, "w");
                if (!fwrite($this->handle, $_GET['w'])) {
                    echo TXT_ERROR;
                } 
            fclose($this->handle);
            echo TXT_FILETO_COPY."<br /><span class='red'>".basename($_GET['w'])."</span>";
            exit;
            }
        exit;
        break;
    case 'upload': //UPLOAD FILES
        $this->do_upload();
        exit;
        break;
    case 'makefolder': //CREATE FOLDER
        $this->do_makedir();
        exit;
        break;
    case 'dummy': //DELETE ezaccess file after xxx seconds (KEEP_COPY)
        if (file_exists($this->ezaccess)) {
            $this->FileCreationTime = filectime($this->ezaccess);
            $this->FileAge = time() - $this->FileCreationTime;
            if ($this->FileAge >= KEEP_COPY){
                @unlink($this->ezaccess);
                }
        }
        break;
    default:
        if (file_exists($this->ezaccess)) {
            $this->handle = fopen($this->ezaccess, "r");
             $this->output = fread($this->handle, filesize($this->ezaccess));
            echo TXT_FILETO_COPY."<br /><span class='red'>".basename($this->output)."</span>";
            fclose($this->handle);
            }
    exit;
}
}    
}
?>