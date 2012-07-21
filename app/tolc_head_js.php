<?php
// prevent direct access
if(!$tolc_include) {
	echo 'Access denied!';
	exit;
}
?>

<script type="text/javascript" src="<?php print JQUERY_URL ?>"></script>
<script type="text/javascript" src="<?php print JQUERY_UI_URL ?>"></script>

<?php
if(!isset($_SESSION['username'])) {

	if(isset($_SESSION['url_reserved'])) {
		switch($_SESSION['url_reserved']) {
			case $tolc_conf['pref_reserved_url_timezone']:
				?>

				<?php
				break;
			case $tolc_conf['pref_reserved_url_login']:
				?>
				<script type="text/javascript"
						src="<?php print $tolc_conf['project_url'] ?>/app/login/login.js?version=4"></script>
				<?php
				break;
		}
	} else {
		if($www_pages_id == 0) {
			?>
		<script type="text/javascript"
				src="<?php print $tolc_conf['project_url'] ?>/app/login/login_required_new_page.js?version=4"></script>
		<?php
		}
	}

} else {
	?>

<script type="text/javascript"
		src="<?php print JQUERY_UI_EXT_AUTOCOMPLETE_HTML_URL ?>"></script>
<script type="text/javascript"
		src="<?php print JQUERY_UI_LAYOUT_URL ?>"></script>
<script type="text/javascript" src="<?php print JSTREE_URL ?>"></script>
<script type="text/javascript" src="<?php print QTIP2_URL ?>"></script>

<script type="text/javascript"
		src="<?php print $tolc_conf['project_url'] ?>/app/admin/admin.js?version=1"></script>
<?php
	if(isset($_SESSION['url_reserved'])) {
		switch($_SESSION['url_reserved']) {
			case $tolc_conf['pref_reserved_url_timezone']:

				break;
			case $tolc_conf['pref_reserved_url_login']:
				?>
				<script type="text/javascript"
						src="<?php print $tolc_conf['project_url'] ?>/app/admin/already_logged_in.js?version=4"></script>
				<?php
				break;
		}
	} else {
		if($www_pages_id == 0) {

		}
	}
	?>

<?php
}
?>

<script type="text/javascript"
		src="<?php print $tolc_conf['project_url'] ?>/app/common/utils.js?version=1"></script>
