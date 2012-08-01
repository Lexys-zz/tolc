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

require_once '../../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_db.php';

// get params
$username = $_POST['username'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$repeat_new_password = $_POST['repeat_new_password'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$url = $_POST['url'];
$password_strength = $_POST['password_strength'];

// check username length
$n = strlen($username);
if($n < $tolc_conf['pref_username_minchars']) {
	print gettext('Username characters are less than') . ' ' . $tolc_conf['pref_username_minchars'] . '...';
	exit;
}
if($n > $tolc_conf['pref_username_maxchars']) {
	print gettext('Username characters are more than') . ' ' . $tolc_conf['pref_username_maxchars'] . '...';
	exit;
}

// check valid username characters
$regex_username = '/[^' . preg_quote($tolc_conf['pref_username_charset']) . ']/';
if(preg_match($regex_username, $username)) {
	print gettext('Username contains invalid characters') . '...';
	exit;
}

// check for reserved usernames | CASE IN-SENSITIVE
if(in_array(mb_strtolower($username), array_map('mb_strtolower', $tolc_conf['pref_reserved_usernames']))) {
	print gettext('Selected username is reserved and cannot be used') . '...';
	exit;
}

// password checks (if password changed)
if($old_password) {
    // check password length
	$n = strlen($new_password);
	if($n < $tolc_conf['pref_password_minchars']) {
		print gettext('Password characters are less than') . ' ' . $tolc_conf['pref_password_minchars'] . '...';
		exit;
	}
	if($n > $tolc_conf['pref_password_maxchars']) {
		print gettext('Password characters are more than') . ' ' . $tolc_conf['pref_password_maxchars'] . '...';
		exit;
	}

    // check password strength
	if($password_strength < $tolc_conf['pref_password_strength']) {
		print gettext('Password strength is less than') . ' ' . $tolc_conf['pref_password_strength'] . '%' . '...';
		exit;
	}

    // check password verification
	if($new_password !== $repeat_new_password) {
		print gettext('New password does not match with its verification') . '...';
		exit;
	}

    //check valid password characters
	$regex_password = '/[^' . preg_quote($tolc_conf['pref_password_charset']) . ']/';
	if(preg_match($regex_password, $old_password)) {
		print gettext('Old password contains invalid characters') . '...';
		exit;
	}
	if(preg_match($regex_password, $new_password)) {
		print gettext('New password contains invalid characters') . '...';
		exit;
	}
	if(preg_match($regex_password, $repeat_new_password)) {
		print gettext('Password verification contains invalid characters') . '...';
		exit;
	}
}

// check for valid email
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	print gettext('Invalid email') . '...';
	exit;
}

// check for valid URL (if given)
if($url && !filter_var($url, FILTER_VALIDATE_URL)) {
	print gettext('Invalid URL') . '...';
	exit;
}

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

// get user current profile
$current_username = $_SESSION['username'];
$sql = 'SELECT * FROM www_users WHERE username=' . $conn->qstr($current_username);
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
} else {
	$www_users_id = $rs->fields['id'];
	$current_password = $rs->fields['password'];
	$current_email = $rs->fields['email'];
}

// check for unique username | CASE IN-SENSITIVE
$username_changed = ($username !== $current_username);
if($username_changed) {
	$sql = 'SELECT id from www_users WHERE LOWER(username)=' . $conn->qstr(mb_strtolower($username));
	$rs = $conn->Execute($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
	} else {
		$rows = $rs->RecordCount();
		if($rows == 1) {
			$found_user_id = $rs->fields['id'];
			if($found_user_id != $www_users_id) {
				print gettext('Given username is currently in use') . '...';
				exit;
			}
		} elseif($rows > 1) {
			trigger_error('SERIOUS ERROR - multiple similar usernames', E_USER_ERROR);
		}
	}
}

// check for correct old_password
if($old_password && (md5($old_password) !== $current_password)) {
	print gettext('Old password is not correct') . '...';
	exit;
}

// check for unique email | CASE IN-SENSITIVE
$email_changed = ($email !== $current_email);
if($email_changed) {
	$sql = 'SELECT id from www_users WHERE LOWER(email)=' . $conn->qstr(mb_strtolower($email));
	$rs = $conn->Execute($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
	} else {
		$rows = $rs->RecordCount();
		if($rows == 1) {
			$found_user_id = $rs->fields['id'];
			if($found_user_id != $www_users_id) {
				print gettext('Given email is currently in use') . '...';
				exit;
			}
		} elseif($rows > 1) {
			trigger_error('SERIOUS ERROR - multiple similar emails', E_USER_ERROR);
		}
	}
}

// proceed to update
$sql = 'UPDATE www_users SET ';
$sql .= $username_changed ? 'username=' . $conn->qstr($username) . ',' : '';
$sql .= ($old_password && (md5($new_password) !== $current_password)) ? 'password=' . $conn->qstr(md5($new_password)) . ',' : '';
$sql .= 'email=' . $conn->qstr($email) . ',';
$sql .= 'fullname=' . $conn->qstr($fullname) . ',';
$sql .= $url ? 'url=' . $conn->qstr($url) . ', ' : 'url=null'. ', ';
$sql .= 'must_change_passwd=0'. ' ';
$sql .= 'WHERE id=' . $www_users_id;

if($conn->Execute($sql) === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}

// finally update $_SESSION['username']
if($username_changed) {
	$_SESSION['username'] = $username;
}
?>