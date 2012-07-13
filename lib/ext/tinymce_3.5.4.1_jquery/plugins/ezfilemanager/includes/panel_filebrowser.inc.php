<?php if ( ! defined('SITE_URL')) exit('No direct script access allowed');?>
<div id="filetype">
 <?php echo TXT_FILTER_BY?><br />
<?php
$filter_by=$ezf->filter_by();
$filter_by_lng=$ezf->filter_by_lng();
for($x=0; $x<sizeof($filter_by); $x++)
{
  $class="";
  ($filter_by[$x]==$active_type) ? $class='panel_active' : $class='panel_status';
  echo "<div id='".$class."'>&nbsp;</div><div id='panel_link'><a href='".CURRENT_URL."&amp;type=".$filter_by[$x].$ezf->pop_url()."'>".$filter_by_lng[$filter_by[$x]]."</a></div><div class='clear_left'></div>";

}
?>
</div>
<div id="dir-stats">
    <?php

echo "<a href='#' id='folder-info'  class='changelink'><span class='red'>[+]</span> <span class='blue'>".CURRENT_FOLDER."</span></a> [".$directory['folder_size']."]";
echo "<div id='folderinfo'>";
echo "<span class='bold'>".TXT_DIRECTORIES."</span> ".sizeof($directory['folder']);
echo "<br />";
echo "<span class='bold'>".TXT_FILE_TYPES."</span> ".$filter_by_lng[$active_type];
echo "<br />";
echo "<span class='bold'>".TXT_FILES."</span> ".sizeof($directory['file']);
echo '<br />';
echo "<span class='bold'>".TXT_SIZE."</span> ".$directory['folder_size'];
echo '</div>';
?>
</div>
<div id="stats-placeholder"><?php echo TXT_CLICK?></div>
<div id="filefactory"></div>
