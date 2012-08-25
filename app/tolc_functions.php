<?php
// prevent direct access
if(!$tolc_include) {
	echo CONST_ACCESS_DENIED . ' (' . __FILE__ . ')';
	exit;
}
?>
<!-- Common ---------------------------------------------------------------- -->
<input type="hidden" id="project_url" value="<?php print $tolc_conf['project_url'] ?>">
<input type="hidden" id="ajax_loading" value="<?php print gettext('Loading') ?>">

<?php
if(!isset($_SESSION['username'])) {

	if(isset($_SESSION['url_reserved'])) {
		switch(mb_strtolower($_SESSION['url_reserved'])) {
			case mb_strtolower($tolc_conf['pref_reserved_urls']['regional']):
				include 'inc_tolc_functions/inc_regional.php';
				break;
			case mb_strtolower($tolc_conf['pref_reserved_urls']['login']):
				include 'inc_tolc_functions/inc_login.php';
				break;
		}
		unset($_SESSION['url_reserved']);
	} else {
		if($www_pages_id == 0) {
			if($valid_url) {
				include 'inc_tolc_functions/inc_login_required_new_page.php';
			} else {
				include 'inc_tolc_functions/inc_invalid_url.php';
			}
		} else {
			if($page_has_been_removed || $www_page_versions_id == 0) {
				include 'inc_tolc_functions/inc_page_not_found.php';
			}
		}
	}

} else {

	if(isset($_SESSION['url_reserved'])) {
		switch(mb_strtolower($_SESSION['url_reserved'])) {
			case mb_strtolower($tolc_conf['pref_reserved_urls']['regional']):
				include 'inc_tolc_functions/inc_regional.php';
				break;
			case mb_strtolower($tolc_conf['pref_reserved_urls']['login']):
				include 'inc_tolc_functions/inc_already_logged_in.php';
				break;
		}
		unset($_SESSION['url_reserved']);
	} else {
		if($www_pages_id == 0) {
			if($valid_url) {
				include 'inc_tolc_functions/inc_new_page.php';
			} else {
				include 'inc_tolc_functions/inc_invalid_url.php';
			}
		}
	}

	include 'inc_tolc_functions/inc_admin_mode.php';

}
?>