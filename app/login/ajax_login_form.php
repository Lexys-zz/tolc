<?php
session_start();
session_regenerate_id(true);

// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if (!$isAjax) {
    print 'Access denied - not an AJAX request...' . ' (' . __FILE__ . ')';
    exit;
}

require_once '../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_db.php';

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

$sql = 'SELECT locale, lang_intl, lang_local FROM www_languages WHERE admin_interface=1 ORDER BY lang_intl';
$rs = $conn->Execute($sql);
if ($rs === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
$a_lang = $rs->GetRows();

// free memory
if ($rs)
    $rs->Close();
//database disconnect
if ($conn)
    $conn->Close();

$a_tmp = explode('.', $_SESSION['locale']);
$current_locale_code = $a_tmp[0];
?>

<div id="user_message">
</div>

<div id="row_username" class="field_container">
    <label id="lbl_username" for="username"
           class="required"><?php print gettext('Username') ?></label>
    <input id="username" type="text" autocomplete="off">
</div>

<div id="row_password" class="field_container">
    <label id="lbl_password" for="password"
           class="required"><?php print gettext('Password') ?></label>
    <input id="password" type="password">
</div>

<div id="row_language" class="field_container">
    <label id="lbl_language" for="language"
           class="required"><?php print gettext('Language') ?></label>
    <select id="language">
        <?php foreach ($a_lang as $lang) { ?>
        <option <?php print $lang['locale'] == $current_locale_code ? ' selected' : '' ?>
            value="<?php print $lang['locale'] ?>"><?php print $lang['lang_intl'] . ' - ' . $lang['lang_local'] . ' - ' . $lang['locale'] ?></option>
        <?php } ?>
    </select>
</div>