<?php
// prevent direct access
if(!$tolc_include) {
	echo 'Access denied!';
	exit;
}
?>
<input type="hidden" id="project_url" value="<?php print PROJECT_URL ?>">

<?php
if(!isset($_SESSION['username'])) {

	if(isset($_SESSION['url_reserved'])) {
		switch($_SESSION['url_reserved']) {
			case PREF_RESERVED_URL_TIMEZONE:
				include 'inc_tolc_functions/inc_timezone.php';
				break;
			case PREF_RESERVED_URL_LOGIN:
				include 'inc_tolc_functions/inc_login.php';
				break;
		}
		unset($_SESSION['url_reserved']);
	} else {
		if($www_pages_id == 0) {
			include 'inc_tolc_functions/inc_login_required_new_page.php';
		}
	}

} else {

	if(isset($_SESSION['url_reserved'])) {
		switch($_SESSION['url_reserved']) {
			case PREF_RESERVED_URL_TIMEZONE:
				include 'inc_tolc_functions/inc_timezone.php';
				break;
			case PREF_RESERVED_URL_LOGIN:
				include 'inc_tolc_functions/inc_already_logged_in.php';
				break;
		}
		unset($_SESSION['url_reserved']);
	} else {
		if($www_pages_id == 0) {
			include 'inc_tolc_functions/inc_new_page.php';
		}
	}

	include 'inc_tolc_functions/inc_admin_mode.php';

}
?>