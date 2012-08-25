<?php
// prevent direct access
if(!$tolc_include) {
	echo CONST_ACCESS_DENIED . ' (' . __FILE__ . ')';
	exit;
}
?>

<script type="text/javascript" src="<?php print JQUERY_URL ?>"></script>
<script type="text/javascript" src="<?php print JQUERY_UI_URL ?>"></script>
<script type="text/javascript" src="<?php print JUI_ALERT_URL ?>"></script>

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
			if($valid_url) {
				?>
			<script type="text/javascript"
					src="<?php print $tolc_conf['project_url'] ?>/app/login/login_required_new_page.js?version=4"></script>
			<?php
			} else {
				?>
			<script type="text/javascript"
					src="<?php print $tolc_conf['project_url'] ?>/app/invalid_url/invalid_url.js?version=1"></script>
			<?php
			}
		} else {
			if($page_has_been_removed || $www_page_versions_id == 0) {
				?>
			<script type="text/javascript"
					src="<?php print $tolc_conf['project_url'] ?>/app/page_not_found/page_not_found.js?version=1"></script>
			<?php
			}
		}
	}

} else {
	?>

<script type="text/javascript"
		src="<?php print JQ_EASY_SLIDE_PANEL_URL ?>"></script>
<script type="text/javascript"
		src="<?php print JQUERY_UI_EXT_AUTOCOMPLETE_HTML_URL ?>"></script>
<!--<script type="text/javascript"
		src="<?php /*print JQUERY_UI_LAYOUT_URL */?>"></script>
<script type="text/javascript" src="<?php /*print JSTREE_URL */?>"></script>-->
<script type="text/javascript" src="<?php print QTIP2_URL ?>"></script>
<script type="text/javascript"
		src="<?php print PASSWORDSTRENGTH_URL ?>"></script>

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
			if($valid_url) {
				?>
			<script type="text/javascript"
					src="<?php print $tolc_conf['project_url'] ?>/app/admin/new_page/new_page.js?version=1"></script>
			<?php
			} else {
				?>
			<script type="text/javascript"
					src="<?php print $tolc_conf['project_url'] ?>/app/invalid_url/invalid_url.js?version=1"></script>
			<?php
			}
		}
	}
	?>

<?php
}
?>

<script type="text/javascript"
		src="<?php print $tolc_conf['project_url'] ?>/app/common/utils.js?version=1"></script>
