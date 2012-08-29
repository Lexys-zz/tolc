<?php
session_start();
session_regenerate_id();

require_once '../../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_db.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_cms.php';
require_once SIMPLE_HTML_DOM_PATH . '/simple_html_dom.php';

// check for logged in user
if(!isset($_SESSION['username'])) {
	print CONST_ACCESS_DENIED . ' (' . __FILE__ . ')';
	exit;
}

// get current time (in UTC)
$dt = now($_SESSION['user_timezone']);

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

// get page
$a_page = get_page($conn, $_SESSION['url']);
$www_pages_id = $a_page['page_id'];
$page_title = $a_page['page_title'];

// get first template date
$first_template_date_start = get_first_template_date($conn, $www_pages_id, $_SESSION['user_timezone']);
$minYear = substr($first_template_date_start, 0, 4);
$minMonth = substr($first_template_date_start, 4, 2);
$minDay = substr($first_template_date_start, 6, 2);
$minHour = substr($first_template_date_start, 8, 2);
$minMin = substr($first_template_date_start, 10, 2);
$minSec = substr($first_template_date_start, 12, 2);

// get page version
$start_page_versions_id = get_page_version($conn, $www_pages_id, $dt, CONST_CONTENT_STATUS_APPROVED_KEY, true);
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php print $page_title ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

	<link href="<?php print JQUERY_UI_CSS_URL ?>" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php print JQUERY_UI_DATETIMEPICKER_CSS_URL ?>"
		  rel="stylesheet" type="text/css">
	<link
		href="<?php print $tolc_conf['project_url'] ?>/app/admin/rte/rte.css?version=1"
		rel="stylesheet"
		type="text/css"/>

	<script type="text/javascript" src="<?php print JQUERY_URL ?>"></script>
	<script type="text/javascript" src="<?php print JQUERY_UI_URL ?>"></script>

	<script type="text/javascript"
			src="<?php print JQUERY_UI_DATETIMEPICKER_URL ?>"></script>

	<?php if(substr($_SESSION['locale'], 0, 2) !== 'en') { ?>
	<script type="text/javascript"
			src="<?php print JQUERY_UI_i18n_DIR . '/jquery.ui.datepicker-' . substr($_SESSION['locale'], 0, 2) . '.js' ?>"></script>
	<script type="text/javascript"
			src="<?php print JQUERY_UI_DATETIMEPICKER_i18n_URL ?>"></script>
	<?php } ?>

	<script type="text/javascript" src="<?php print JUI_ALERT_URL ?>"></script>

	<script type="text/javascript"
			src="<?php print JQUERY_TINYMCE_URL ?>"></script>
	<script type="text/javascript"
			src="<?php print $tolc_conf['project_url'] ?>/app/admin/rte/rte.js?version=1"></script>
</head>

<body>

<div id="user_message">
</div>

<fieldset class="ui-widget ui-widget-content">
	<legend class="ui-widget-header ui-corner-all"
			title="<?php print gettext('Show/hide tools') ?>">
		<div><?php print gettext('Edit') ?></div>
	</legend>

	<div id="rte_tools1" class="rte_tools">
		<span
			id="page_activate"><?php print gettext('Page has been removed. To activate it, press here') . ': '?></span>
		<a id="btn_activate"><?php print gettext('Activate page') ?></a>
		<span
			id="page_remove"><?php print gettext('To remove the whole page, press here') . ': '?></span>
		<a id="btn_remove"><?php print gettext('Remove page') ?></a>
	</div>


	<div id="rte_tools2" class="rte_tools">
		<span
			id="new_page_version"><?php print gettext('New content version') . ': '?></span>
		<label id="lbl_www_page_versions_id"
			   for="www_page_versions_id"><?php print gettext('Page versions') ?></label>
		<br/>
		<select id="www_page_versions_id">
		</select>

		<a id="btn_delete"><?php print gettext('Delete version') ?></a>
		<a id="btn_clone"><?php print gettext('New version like current') ?></a>
	</div>

	<div id="rte_tools3" class="rte_tools">

		<div id="save" class="label_over_input">
			<a id="btn_addnew"><?php print gettext('Add new version') ?></a>
			<a id="btn_save"><?php print gettext('Save version') ?></a>
		</div>

		<div id="author" class="label_over_input">
			<label
				for="author_id"><?php print gettext('Submitted from') ?></label>
			<br>
			<select id="author_id">
			</select>
		</div>

		<div id="date_start" class="label_over_input">
			<label
				for="date_publish_start"><?php print gettext('Published from') ?></label>
			<br>
			<input id="date_publish_start">
		</div>

		<div id="date_end" class="label_over_input">
			<label
				for="date_publish_end"><?php print gettext('until') ?></label>
			<br>
			<input id="date_publish_end">
		</div>

		<div id="content_status" class="label_over_input">
			<label
				for="lk_content_status_id"><?php print gettext('Content status') ?></label>
			<br>
			<select id="lk_content_status_id">
			</select>
		</div>

		<div id="editor" class="label_over_input">
			<label for="editor_id"><?php print gettext('Managed by') ?></label>
			<br>
			<select id="editor_id">
			</select>
		</div>

	</div>

</fieldset>

<div id="rte_div">
	<textarea id="rte" rows="10" cols="60">
	</textarea>
</div>

<div id="dialog">
</div>


<input id="lang" type="hidden"
	   value="<?php print substr($_SESSION['locale'], 0, 2) ?>">
<input id="dateformat" type="hidden"
	   value="<?php print $a_date_format[$_SESSION['user_dateformat']]['jq_date'] ?>">
<input id="timeformat" type="hidden"
	   value="<?php print $a_date_format[$_SESSION['user_dateformat']]['jq_time'] ?>">
<input id="pref_tinymce_toggle_toolbar" type="hidden"
	   value="<?php print $tolc_conf['pref_tinymce_toggle_toolbar'] ? '1' : '0' ?>">
<input id="rsc_please_select" type="hidden"
	   value="<?php print gettext('Please, select') ?>">

<input id="start_page_versions_id" type="hidden"
	   value="<?php print $start_page_versions_id ?>">
<input id="minYear" type="hidden" value="<?php print $minYear ?>">
<input id="minMonth" type="hidden" value="<?php print $minMonth ?>">
<input id="minDay" type="hidden" value="<?php print $minDay ?>">
<input id="minHour" type="hidden" value="<?php print $minHour ?>">
<input id="minMin" type="hidden" value="<?php print $minMin ?>">
<input id="minSec" type="hidden" value="<?php print $minSec ?>">
</body>

</html>