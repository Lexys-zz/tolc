<?php
session_start();
session_regenerate_id(true);

// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	print 'Access denied - not an AJAX request...' . ' (' . __FILE__ . ')';
	exit;
}

require_once '../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils.php';

$current_timezone = $_SESSION['user_timezone'];
$current_dateformat = $_SESSION['user_dateformat'];
?>

<div id="row_timezone" class="field_container">
	<label id="lbl_timezone" for="timezone"
		   class="required"><?php print gettext('Timezone') ?></label>
	<select id="timezone">
		<?php foreach(tz_list() as $tz) { ?>
		<option <?php print $current_timezone == $tz['zone'] ? ' selected' : '' ?>
			value="<?php print $tz['zone'] ?>"><?php print $tz['zone'] . ' (' . $tz['diff_from_GMT'] . ')' ?></option>
		<?php } ?>
	</select>
</div>

<div id="row_dateformat" class="field_container">
	<label id="lbl_dateformat" for="dateformat"
		   class="required"><?php print gettext('Date format') ?></label>
	<select id="dateformat">
		<?php foreach(df_list($a_date_format, $current_timezone) as $df_key => $df_val) { ?>
		<option <?php print $current_dateformat == $df_key ? ' selected' : '' ?>
			value="<?php print $df_key ?>"><?php print str_replace('_', '&nbsp;', str_pad($df_val['example'], 20, "_", STR_PAD_LEFT)) .
			str_replace('_', '&nbsp;', str_pad($df_val['dateformat'], 15, '_', STR_PAD_LEFT)) ?></option>
		<?php } ?>
	</select>
</div>