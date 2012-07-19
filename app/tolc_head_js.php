<?php
// prevent direct access
if(!$tolc_include) {
	echo 'Access denied!';
	exit;
}
?>
<script type="text/javascript" src="<?php print JQUERY_URL ?>"></script>
<script type="text/javascript" src="<?php print JQUERY_UI_URL ?>"></script>

<?php if(isset($_SESSION['username'])) { ?>
<script type="text/javascript"
		src="<?php print JQUERY_UI_EXT_AUTOCOMPLETE_HTML_URL ?>"></script>
<script type="text/javascript"
		src="<?php print JQUERY_UI_LAYOUT_URL ?>"></script>
<script type="text/javascript" src="<?php print JSTREE_URL ?>"></script>
<script type="text/javascript" src="<?php print QTIP2_URL ?>"></script>
<?php } ?>

<script type="text/javascript"
		src="<?php print PROJECT_URL ?>/app/common/utils.js?version=1"></script>

<?php if($_SESSION['url_reserved'] == PREF_RESERVED_URL_LOGIN) { ?>
<?php if(!isset($_SESSION['username'])) { ?>
	<script type="text/javascript"
			src="<?php print PROJECT_URL ?>/app/login/login.js?version=4"></script>
	<?php } else { ?>
	<script type="text/javascript"
			src="<?php print PROJECT_URL ?>/app/admin/already_logged_in.js?version=4"></script>
	<?php } ?>
<?php } ?>

<?php if(!isset($_SESSION['username']) && $www_pages_id == 0) { ?>
<script type="text/javascript"
		src="<?php print PROJECT_URL ?>/app/login_required_new_page.js?version=4"></script>
<?php } ?>

<?php if(isset($_SESSION['username'])) { ?>
<script type="text/javascript"
		src="<?php print PROJECT_URL ?>/app/admin/admin.js?version=1"></script>
<?php } ?>