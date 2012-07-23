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
		switch(mb_strtolower($_SESSION['url_reserved'])) {
			case mb_strtolower($tolc_conf['pref_reserved_urls']['regional']):
				?>
				<link
					href="<?php print $tolc_conf['project_url'] ?>/app/regional/regional.css?version=1"
					rel="stylesheet" type="text/css"/>
				<?php
				break;
			case mb_strtolower($tolc_conf['pref_reserved_urls']['login']):
				?>
				<link
					href="<?php print $tolc_conf['project_url'] ?>/app/login/login.css?version=6"
					rel="stylesheet" type="text/css"/>
				<?php
				break;
		}
	} else {
		if($www_pages_id == 0) {
			?>
		<link
			href="<?php print $tolc_conf['project_url'] ?>/app/login/login_required_new_page.css?version=1"
			rel="stylesheet" type="text/css"/>
		<?php
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
		switch(mb_strtolower($_SESSION['url_reserved'])) {
			case mb_strtolower($tolc_conf['pref_reserved_urls']['regional']):
				?>
				<link
					href="<?php print $tolc_conf['project_url'] ?>/app/regional/regional.css?version=1"
					rel="stylesheet" type="text/css"/>
				<?php
				break;
			case mb_strtolower($tolc_conf['pref_reserved_urls']['login']):

				break;
		}
	} else {
		if($www_pages_id == 0) {
			?>
		<link
			href="<?php print $tolc_conf['project_url'] ?>/app/admin/new_page/new_page.css?version=1"
			rel="stylesheet" type="text/css"/>
		<?php
		}
	}
	?>

<?php
}
?>