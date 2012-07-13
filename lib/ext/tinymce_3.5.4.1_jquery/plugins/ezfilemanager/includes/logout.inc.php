<?php if ( ! defined('SITE_URL')) exit('No direct script access allowed');?>
<?php if (LOGIN_FORM){?>
<div style='width:60px;float:right'><a href='?logout=1<?php echo '&amp;'.$_SERVER['QUERY_STRING'];?>'><?php echo TXT_LOGOUT?></a></div>
<?php } ?>