<?php
session_start();
session_regenerate_id(true);

// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	print 'Access denied - not an AJAX request...';
	exit;
}

require_once '../../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_db.php';

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

$sql = 'SELECT * FROM www_users WHERE username=' . $conn->qstr($_SESSION['username']);
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
$username = $rs->fields['username'];
$email = $rs->fields['email'];
$fullname = $rs->fields['fullname'];
$url = $rs->fields['url'];

// free memory
if($rs)
	$rs->Close();
//database disconnect
if($conn)
	$conn->Close();
?>

<div id="user_message">
</div>

<div id="row_username" class="field_container">
	<label id="lbl_username" class="required"
		   for="username"><?php print gettext('Username') ?></label>
	<input id="username" type="text" autocomplete="off"
		   value="<?php print $username ?>">
</div>

<hr>

<div id="row_old_password" class="field_container">
	<label id="lbl_old_password"
		   for="old_password"><?php print gettext('Old password') ?></label>
	<input id="old_password" type="password" autocomplete="off">
</div>

<div id="row_new_password" class="field_container">
	<label id="lbl_new_password"
		   for="new_password"><?php print gettext('New password') ?></label>
	<input id="new_password" type="password" autocomplete="off">
	<span id="password_tools_generate" class="password_tools">
		<a id="generate_password" href="javascript:void(0);"><?php print gettext('Generate')?></a>
	</span>
	<span id="password_tools_mask" class="password_tools">
	<a id="mask_password_toggle"
	   href="javascript:void(0)"><?php print gettext('Unmask')?></a>
    </span>
</div>

<div id="passwordStrengthDiv" class="is0"
	 style="margin-left: 30%; clear: both;"></div>


<div id="row_repeat_new_password" class="field_container">
	<label id="lbl_repeat_new_password"
		   for="repeat_new_password"><?php print gettext('Repeat') ?></label>
	<input id="repeat_new_password" type="password" autocomplete="off">
</div>

<hr>
<div id="row_fullname" class="field_container">
	<label id="lbl_fullname" class="required"
		   for="fullname"><?php print gettext('Full name') ?></label>
	<input id="fullname" type="text" autocomplete="off"
		   value="<?php print $fullname ?>">
</div>

<div id="row_email" class="field_container">
	<label id="lbl_email" class="required"
		   for="email"><?php print gettext('Email') ?></label>
	<input id="email" type="text" autocomplete="off"
		   value="<?php print $email ?>">
</div>

<div id="row_url" class="field_container">
	<label id="lbl_url"
		   for="url"><?php print gettext('URL') ?></label>
	<input id="url" type="text" autocomplete="off"
		   value="<?php print $url ?>">
</div>