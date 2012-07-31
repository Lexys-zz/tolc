<?php
session_start();
session_regenerate_id(true);

// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	print 'Access denied - not an AJAX request...';
	exit;
}

// check for logged in user
if(!isset($_SESSION['username'])) {
	print gettext('Access denied') . '...';
	exit;
}

require_once '../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';

// get params
$id = $_GET['id'];
$a_topic = explode("-", $id);
$form = $a_topic[1];
$control = $a_topic[2];
?>

<?php if($form == 'user_profile') { ?>

<?php if($control == 'username') { ?>
	<p class="help">
		<?php print gettext('Username can use any combination of the following characters') . ':' ?>
	</p>

	<p class="help">
		<strong><?php print $tolc_conf['pref_username_charset']; ?></strong></p>
	<?php } ?>

<?php if($control == 'password') { ?>
	<p class="help">
		<?php print gettext('Password can use any combination of the following characters') . ':' ?>
	</p>

	<p class="help">
		<strong><?php print $tolc_conf['pref_password_charset']; ?></strong></p>
	<?php } ?>

<?php } ?>


