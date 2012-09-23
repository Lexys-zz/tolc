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
<?php
echo "<div id='allowed'>";
echo "<span class='red'>".TXT_MAX_UPLOAD."</span> ".$ezf->bytestostring(MAX_UPLOAD_SIZE);
echo "<br />";
echo "<span class='red'>".TXT_YOU_CAN."</span><br />";
 $ezf_file_type= $ezf->ezf_file_extensions();
foreach ($ezf_file_type['filetype']['image'] as $i => $value) {
echo $value." ";
}
echo "<br />";
foreach ($ezf_file_type['filetype']['media'] as $i => $value) {
echo $value." ";
}
echo "<br />";
foreach ($ezf_file_type['filetype']['file'] as $i => $value) {
echo $value." ";
}

echo "</div>";
?>
<div id='info'><?php echo TXT_WAITING?></div>

