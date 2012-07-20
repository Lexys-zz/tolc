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
			case $tolc_conf['pref_reserved_url_timezone']:
				?>

				<?php
				break;
			case $tolc_conf['pref_reserved_url_login']:
				?>
				<link
					href="<?php print $tolc_conf['project_url'] ?>/app/login/login.css?version=6"
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
<link href="<?php print $tolc_conf['project_url'] ?>/app/admin/admin.css" rel="stylesheet"
	  type="text/css"/>
<?php
	if(isset($_SESSION['url_reserved'])) {
		switch($_SESSION['url_reserved']) {
			case $tolc_conf['pref_reserved_url_timezone']:

				break;
			case $tolc_conf['pref_reserved_url_login']:

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