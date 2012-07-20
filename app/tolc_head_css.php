<?php
// prevent direct access
if(!$tolc_include) {
	echo 'Access denied!';
	exit;
}
?>
<link href="<?php print JQUERY_UI_CSS_URL ?>" rel="stylesheet" type="text/css"/>

<?php
if(!isset($_SESSION['username'])) {

	if(isset($_SESSION['url_reserved'])) {
		switch($_SESSION['url_reserved']) {
			case PREF_RESERVED_URL_TIMEZONE:
				?>

				<?php
				break;
			case PREF_RESERVED_URL_LOGIN:
				?>
				<link
					href="<?php print PROJECT_URL ?>/app/login/login.css?version=6"
					rel="stylesheet" type="text/css"/>
				<?php
				break;
		}
	} else {
		if($www_pages_id == 0) {

		}
	}

} else {
	?>
<link href="<?php print JQUERY_UI_LAYOUT_CSS_URL ?>" rel="stylesheet"
	  type="text/css"/>
<link href="<?php print QTIP2_CSS_URL ?>" rel="stylesheet" type="text/css"/>
<link href="<?php print PROJECT_URL ?>/app/admin/admin.css" rel="stylesheet"
	  type="text/css"/>
<?php
	if(isset($_SESSION['url_reserved'])) {
		switch($_SESSION['url_reserved']) {
			case PREF_RESERVED_URL_TIMEZONE:

				break;
			case PREF_RESERVED_URL_LOGIN:

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