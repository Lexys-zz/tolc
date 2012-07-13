<?php if ( ! defined('SITE_URL')) exit('No direct script access allowed');?>
 <div class='filenav_tab' id='filenav_tab'>
<?php    
$directory=$ezf->read_folder();
(ENABLE_RENAME && !NON_WRITABLE) ? $editable_textarea="editable_textarea" : $editable_textarea="x_textarea";
(!NON_WRITABLE) ? $copyfolder="folder" : $copyfolder="folderx";
if (isset($_GET['tmce'])){
    $insert_emptycell = "<td class='tinymce_incert'></td>";
    $folder_colspan = " colspan='3'";
}else{
$folder_colspan = " colspan='4'";
$insert_emptycell = "";    
}
$x=0;
echo "<table class='filebrowsertbl' id='filebrowsertbl'>";
foreach ($directory['folder'] as $folder) {
     $x++;
    (ENABLE_DELETE && !NON_WRITABLE) ? $delcheckbox="<input class='delcheckbox' type='checkbox' name='delete_dir[".CURRENT_PATH.$folder."]' value='1' id='delimput".$x."' />" : $delcheckbox="&nbsp;";
  echo "<tr>\n";
  echo $insert_emptycell;
  echo "<td class='del'><div class='delete".ENABLE_DELETE."' id='dir".$x."'>".$delcheckbox."</div></td>\n";
  echo "<td class='icons' id='".$copyfolder."'><a href='".CURRENT_URL.$folder."/".$ezf->type_url()."' class='folder' title='".TXT_OPEN_FOLDER." ".CURRENT_FOLDER."' id='durl".$x."'>&nbsp;</a></td>\n";
  echo "<td class='dirname'><span class='".$editable_textarea."' id='".CURRENT_PATH."|".$folder."|dummy|dir|".$x."'   style='display: inline'>".$folder."</span></td>\n";
  echo "<td".$folder_colspan." class='datetd'><span>".$directory['folder_date'][$folder]."</span><div class='clear_left'></div></td>\n";
   echo "</tr>\n";
   if (($x)==sizeof($directory['folder'])){
    echo "<tr>\n";
    echo "<td colspan='7'  id='etable'>&nbsp;</td>";
    echo "</tr>\n";
   }
  
    
 }   
foreach ($directory['file'] as $file) {
     $x++;
 if (isset($_GET['tmce'])){
    $file_colspan="";
    if ($_GET['tmce']==1){
        $insert_filecell = "<td class='tinymce_incert'><a href='#' onclick='ezDialogue.fileSubmit(\"".SITE_URL."/".CURRENT_PATH.rawurlencode($file)."\");return false' title='".TXT_INSERT." ".$file."'><img  src='css/images/insert.gif' alt='".TXT_INSERT." ".$file."' /></a>
</td>\n";
    }else{
        $insert_filecell = "<td class='tinymce_incert'><a href='#' onclick='linkinsert(\"".SITE_URL."/".CURRENT_PATH.rawurlencode($file)."\");return false' title='".TXT_INSERT." ".$file."'><img  src='css/images/insert.gif' alt='".TXT_INSERT." ".$file."' /></a>
</td>\n";   
    }
}else{
    $insert_filecell="";
    $file_colspan = " colspan='2'";   
}
$tr_class = (@$tr_class == "row2") ? "row1" : "row2";
echo "<tr class='".$tr_class."'>\n";
(ENABLE_DELETE && !NON_WRITABLE) ? $delcheckbox1="<input class='delcheckbox' type='checkbox' name='delete_file[".CURRENT_PATH.$file."]' value='1'  id='delfile".$x."_".$directory['file_info'][$file]['dimension']."' />" : $delcheckbox1="";
echo $insert_filecell;
  echo "<td class='del'><div class='delete".ENABLE_DELETE."' id='".$x."'>".$delcheckbox1."</div></td>\n";
echo "<td class='icons>";
echo "<div class='view' id='myview'><a href='/".CURRENT_PATH.$file."' class='".$directory['file_info'][$file]['class']."' rel='".CURRENT_PATH.$file."' id='".$x."_".$directory['file_info'][$file]['dimension']."' title='".$directory['file_info'][$file]['type']."-".TXT_CLICK_ICON."'><img  src='css/images/icons/".$directory['file_info'][$file]['icon']."' alt='".$directory['file_info'][$file]['type']."-".TXT_CLICK_ICON."' /></a></div></td>\n";
  echo "<td class='filename'><span class='".$editable_textarea."' id='".CURRENT_PATH."|".$file."|".$ezf->get_raw_extension($file)."|file|".$x."|".$x."_".$directory['file_info'][$file]['dimension']."'  style='display: inline'>".$ezf->strip_extension($file)."</span><span id='ext'>.".$ezf->get_raw_extension($file)."</span></td>\n";
  echo "<td class='datetd'>".$directory['file_info'][$file]['file_date']."</td>\n";
  echo "<td".$file_colspan." class='filesize'>".$directory['file_info'][$file]['filesize']."</td>\n";

echo "</tr>\n";
 }
echo "</table>";
?>
</div>
<input type='hidden' name='action' />