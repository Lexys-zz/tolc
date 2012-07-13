<?php if ( ! defined('SITE_URL')) exit('No direct script access allowed');?>
<div id="breadcrumbs"><?php echo $ez_navigation=$ezf->navigation_links();?><?php include("includes/logout.inc.php")?></div>
<?php

if ($ezf->check_if_writable(ABSOLUT_PATH.CURRENT_PATH)){
echo "<div class='error'>".TXT_NON_WRITABLE."</div>";
 }

 ?>
<?php if (NON_WRITABLE){
echo "<div id='dummy'>&nbsp;</div>";
 }else{?>
<div id="toolbar">
<?php if (ENABLE_DELETE){?>
      <input type="checkbox" id="select_all" class="delete1" title="<?php echo TXT_SELECT_ALL;?>" /> <input type="submit" value="&nbsp;" class="delicon" name="dodelete" id="dodelete"  title="<?php echo TXT_DELETE;?>" />
<?php }?><span><a href='?action=pastehere&amp;w=<?php echo rawurlencode(substr(CURRENT_URL, 3));?>' class='pastehere' title='<?php echo TXT_PASTE?>'><span id='ezpaste'><img  src='css/images/paste.png' alt='<?php echo TXT_PASTE?>' /></span></a></span></div>
<?php }?>