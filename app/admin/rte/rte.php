<?php
session_start();
session_regenerate_id(true);

require_once '../../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_db.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils.php';
require_once SIMPLE_HTML_DOM_PATH . '/simple_html_dom.php';

// check for logged in user
if(!isset($_SESSION['username'])) {
	print CONST_ACCESS_DENIED . ' (' . __FILE__ . ')';
	exit;
}
?>


<!DOCTYPE html>
<html>

<head>
	<title><?php print gettext('Edit') ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="<?php print JQUERY_UI_CSS_URL ?>" rel="stylesheet"
		  type="text/css"/>
	<link
		href="<?php print $tolc_conf['project_url'] ?>/app/admin/rte/rte.css?version=1"
		rel="stylesheet"
		type="text/css"/>
	<script type="text/javascript" src="<?php print JQUERY_URL ?>"></script>
	<script type="text/javascript" src="<?php print JQUERY_UI_URL ?>"></script>
	<script type="text/javascript"
			src="<?php print JQUERY_TINYMCE_URL ?>"></script>
	<script type="text/javascript"
			src="<?php print $tolc_conf['project_url'] ?>/app/admin/rte/rte.js?version=1"></script>
</head>

<body>

<div id="rte_tools">

	<a id="btn_save"><?php print gettext('Save') ?></a>
	<label for="date_start"><?php print gettext('From') ?></label>
	<input id="date_start">
	<label for="date_end"><?php print gettext('Until') ?></label>
	<input id="date_end">
	<select id="lk_publish_status_id">
	</select>


</div>

<div id="rte_div">
	<textarea id="rte" rows="10" cols="60">
	</textarea>
</div>
</body>

</html>