<?php if ( ! defined('SITE_URL')) exit('No direct script access allowed');?>
<div id="dir-stats">
    <?php
echo "<span class='blue'>".CURRENT_FOLDER."</span>";
echo "<br />";
echo "<span class='bold'>".TXT_DIRECTORIES."</span> ".sizeof($directory['folder']);
echo "<br />";
echo "<span class='bold'>".TXT_FILE_TYPES."</span> ".$filter_by_lng[$active_type];
echo "<br />";
echo "<span class='bold'>".TXT_FILES."</span> ".sizeof($directory['file']);
echo '<br />';
echo "<span class='bold'>".TXT_SIZE."</span> ".$directory['folder_size'];

?>
</div>
<div id='infomakedir'><?php echo TXT_WAITING?></div>

