<?php
// prevent direct access
if(!$tolc_include) {
	echo 'Access denied!';
	exit;
}
?>
<link href="<?php print JQUERY_UI_CSS_URL ?>" rel="stylesheet" type="text/css"/>

<?php if($_SESSION['url_reserved'] == PREF_RESERVED_URL_LOGIN) { ?>
<?php if(!isset($_SESSION['username'])) { ?>
	<link href="<?php print PROJECT_URL ?>/app/login/login.css?version=6"
		  rel="stylesheet" type="text/css"/>
	<?php } ?>
<?php } ?>

<?php if(isset($_SESSION['username'])) { ?>
<link href="<?php print JQUERY_UI_LAYOUT_CSS_URL ?>" rel="stylesheet"
	  type="text/css"/>
<link href="<?php print QTIP2_CSS_URL ?>" rel="stylesheet" type="text/css"/>
<link href="<?php print PROJECT_URL ?>/app/admin/admin.css" rel="stylesheet"
	  type="text/css"/>
<?php } ?>
