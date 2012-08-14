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

// check for logged in user
if(!isset($_SESSION['username'])) {
	print 'Access denied' . ' (' . __FILE__ . ')';
	exit;
}

require_once '../../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_db.php';

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

$sql = 'SELECT id, template_name FROM www_templates ORDER BY display_order';
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
$a_templates = $rs->GetRows();

// free memory
if($rs)
	$rs->Close();
//database disconnect
if($conn)
	$conn->Close();

?>

<div id="user_message">
</div>

<div id="row_url" class="field_container">
	<label id="lbl_page_url" for="page_url"
		   class="required"><?php print gettext('New page URL') ?></label>
	<input id="page_url" type="text" value="<?php print $_SESSION['url'] ?>"
		   maxlength="<?php print min($tolc_conf['pref_url_max_length'], CONST_URL_DB_MAXLENGTH) ?>">
</div>

<div id="row_page_title" class="field_container">
	<label id="lbl_page_title" for="page_title"
		   class="required"><?php print gettext('Page title') ?></label>
	<input id="page_title" type="text" maxlength="254">
</div>

<div id="row_www_templates_id" class="field_container">
	<label id="lbl_www_templates_id" for="www_templates_id"
		   class="required"><?php print gettext('Template') ?></label>
	<select id="www_templates_id">
		<option value="0"><?php print gettext('Please, select') ?></option>
		<?php foreach($a_templates as $template) { ?>
		<option
			value="<?php print $template['id'] ?>"><?php print $template['template_name'] ?></option>
		<?php } ?>
	</select>
</div>

<div id="row_parent_id" class="field_container">
	<label id="lbl_parent_title" for="parent_title"
		   class="required"><?php print gettext('Belongs to') ?></label>
	<input id="parent_title" type="text">
	<br><br><br>
	<input id="parent_id" type="hidden">
</div>