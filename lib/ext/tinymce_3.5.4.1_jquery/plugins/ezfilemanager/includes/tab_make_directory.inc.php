<?php if ( ! defined('SITE_URL')) exit('No direct script access allowed');?>
<div id="breadcrumbs"><?php echo $ez_navigation;?></div>
 <?php if (NON_WRITABLE){
echo "<div class='error'>".TXT_NON_WRITABLE."</div>";
 }else{
 ?>
<div id='generalinfo'><?php echo TXT_MAKE_DIR_IN.": <span class='blue'>".CURRENT_FOLDER."</span> (".CURRENT_PATH.")";?></div>
<div id="make_dir_tab">
<form action="" method="post" enctype="multipart/form-data" name="make_dir_form" id="make_dir_form">
<p>&nbsp;</p>
<?php echo TXT_NEW_DIR." ".TXT_NEW_DIR_INFO;?>
<br />

<textarea name='newdir' id='newdir' /></textarea>
<br />
<input type='hidden' name='hash' id='hash' value='aebg=yyyu' />
<input type="submit" value="<?php echo TXT_MAKE?>"  id='submit1' name='submit1' class='ezbutton' />
</form>


</div>
 <div id='panel'><?php include("includes/panel_make_directory.inc.php")?></div>
  <div class='clear_left'></div>
<?php }?>
