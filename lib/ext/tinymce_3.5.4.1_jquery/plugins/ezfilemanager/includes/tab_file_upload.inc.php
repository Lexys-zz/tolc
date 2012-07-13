<?php if ( ! defined('SITE_URL')) exit('No direct script access allowed');?>
<div id="breadcrumbs"><?php echo $ez_navigation; ?></div>
 <?php if (NON_WRITABLE){
echo "<div class='error'>".TXT_NON_WRITABLE."</div>";
 }else{
 ?>
<div id='generalinfo'><?php echo TXT_UPLOAD_TO.": <span class='blue'>".CURRENT_FOLDER."</span> (".CURRENT_PATH.")";?></div>
<form action="" method="post" enctype="multipart/form-data" name="upload_form" id="upload_form">
  <input type="hidden" name="numfiles"  id="numfiles" value="1" />
  <input type="hidden" name="action"  id="action" value="upload" />
  <div id="upload_tab">
    <br />
<div id='uploaddiv1'>
<div class='rename'><?php echo "<span class='red'>#1</span> ".TXT_RENAME?></div>
<div class='selectfile'><?php echo TXT_SELECT_FILE." (".TXT_MAX_UPLOAD." <span class='bold'>".$ezf->bytestostring(MAX_UPLOAD_SIZE)."</span>)";?></div>
<div class='clear_left'></div>
<input id="newfilename1" name="newfilename1" type="text" size="35" class='fieldtext' maxlength="200"  value="" />

<input type="file" name="filename1" id="filename1"   class='fieldtextfile'  onchange="updateFileName(this,'1')" />&nbsp;
<br>

<?php for ($i = 2; $i <= MAX_SIM_UPLOAD; $i++) {
echo "<div id='uploaddiv".($i)."'></div>";

}
?>
</div>
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_UPLOAD_SIZE ?>">
<input type='hidden' name='upload_now' id='upload_now' value='1' />
<?php if (MAX_SIM_UPLOAD>1){?>
<input type='button' name='remupload' id='remupload' value='<?php echo TXT_REMOVE?>' class='buttonremove' onClick='remove_upload();' title='<?php echo TXT_REMOVE?>' />
<br /><br />
<?php }?>
<input type="submit" value="<?php echo TXT_UPLOAD?>"  id='submit1' name='submit1'  class="ezbutton" title='<?php echo TXT_UPLOAD?>' />
<?php if (MAX_SIM_UPLOAD>1){?>
<input type="button" name="addupload"  id='addupload' value="<?php echo TXT_UPLOAD_ADD;?>" class="buttonadd" onclick="addnewupload();" title='<?php echo TXT_UPLOAD_ADD?>' />

<?php }?>



</div>
</form>
 <div id='panel'><?php include("includes/panel_file_upload.inc.php")?></div>
 <div class='clear_left'></div>
<?php } ?>
