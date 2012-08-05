<?php
// prevent direct access
if(!$tolc_include) {
	echo 'Access denied!';
	exit;
}
?>

<script type="text/javascript" src="<?php print JQUERY_URL ?>"></script>
<script type="text/javascript" src="<?php print JQUERY_UI_URL ?>"></script>
<script type="text/javascript" src="<?php print JUI_ALERT_URL ?>"></script>

<script type="text/javascript" src="<?php print LIB_URL . LIB_EXT_DIR ?>/bootstrap_2.0.4/js/bootstrap.min.js"></script>

<?php
if(!isset($_SESSION['username'])) {

	if(isset($_SESSION['url_reserved'])) {
		switch(mb_strtolower($_SESSION['url_reserved'])) {
			case mb_strtolower($tolc_conf['pref_reserved_urls']['regional']):
				?>
				<script type="text/javascript"
						src="<?php print $tolc_conf['project_url'] ?>/app/regional/regional.js?version=1"></script>
				<?php
				break;
			case mb_strtolower($tolc_conf['pref_reserved_urls']['login']):
				?>
				<script type="text/javascript"
						src="<?php print $tolc_conf['project_url'] ?>/app/login/login.js?version=5"></script>
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
<script type="text/javascript" src="<?php print PASSWORDSTRENGTH_URL ?>"></script>

<script type="text/javascript"
		src="<?php print $tolc_conf['project_url'] ?>/app/admin/admin.js?version=1"></script>
<?php
	if(isset($_SESSION['url_reserved'])) {
		switch(mb_strtolower($_SESSION['url_reserved'])) {
			case mb_strtolower($tolc_conf['pref_reserved_urls']['regional']):
				?>
				<script type="text/javascript"
						src="<?php print $tolc_conf['project_url'] ?>/app/regional/regional.js?version=1"></script>
				<?php
				break;
			case mb_strtolower($tolc_conf['pref_reserved_urls']['login']):
				?>
				<script type="text/javascript"
						src="<?php print $tolc_conf['project_url'] ?>/app/admin/already_logged_in.js?version=4"></script>
				<?php
				break;
		}
	} else {
		if($www_pages_id == 0) {
			?>
		<script type="text/javascript"
				src="<?php print $tolc_conf['project_url'] ?>/app/admin/new_page/new_page.js?version=1"></script>
		<?php
		}
	}
	?>

<?php
}
?>

<script type="text/javascript"
		src="<?php print $tolc_conf['project_url'] ?>/app/common/utils.js?version=1"></script>
