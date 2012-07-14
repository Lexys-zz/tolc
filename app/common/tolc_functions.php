<input type="hidden" id="admin_mode"
       value="<?php print $admin_mode ? '1' : '0' ?>">
<input type="hidden" id="project_url" value="<?php print PROJECT_URL ?>">
<input type="hidden" id="base_url" value="<?php print BASE_URL ?>">
<input type="hidden" id="url" value="<?php print $url ?>">
<input type="hidden" id="new_page" value="<?php print $new_page ? '1' : '0' ?>">
<input type="hidden" id="login"
       value="<?php print $login ? '1' : '0' ?>">
<input type="hidden" id="btn_ok" value="<?php print gettext('Ok') ?>">
<input type="hidden" id="active_elements"
       value="<?php print $active_elements ?>">

<?php if (!$admin_mode && $new_page) { ?>
<div id="login_required_new_page"
     title="<?php print gettext('Login required')?>">
    <?php print gettext('Page does not exist. Login required to create this page') . '...' ?>
</div>
<?php } ?>

<?php if (!$admin_mode && $login) { ?>
<?php
    $sql = 'SELECT locale, lang_intl, lang_local FROM www_languages WHERE admin_interface=1 ORDER BY lang_intl';
    $rs = $conn->Execute($sql);
    if ($rs === false) {
        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
    }
    $a_lang = $rs->GetRows();
    ?>
<div id="login_form" title="<?php print gettext('Login')?>">

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
            <option
                value="<?php print $lang['locale'] ?>"><?php print $lang['lang_intl'] . ' - ' . $lang['lang_local'] . ' - ' . $lang['locale'] ?></option>
            <?php } ?>
        </select>
    </div>

</div>

<input type="hidden" id="btn_do_login_value"
       value="<?php print gettext('Login') ?>">
<input type="hidden" id="btn_cancel_login_value"
       value="<?php print gettext('Cancel') ?>">
<input type="hidden" id="msg_username_required"
       value="<?php print gettext('Username is required') . '...' ?>">
<input type="hidden" id="msg_password_required"
       value="<?php print gettext('Password is required') . '...' ?>">

<?php } ?>

<?php if ($admin_mode && $login) { ?>
<div id="already_login"
     title="<?php print gettext('Login')?>">
    <?php print gettext('Already logged in') . '...'; ?>
</div>
<?php } ?>

<?php if ($admin_mode) { ?>
<input id="tinymce_url" type="hidden" value="<?php print TINYMCE_URL ?>">
<input id="content_css_url" type="hidden"
       value="<?php print PROJECT_URL . $template_path . $css_url ?>">
<input id="ezfilemanager_url" type="hidden"
       value="<?php print EZFILEMANAGER_URL ?>">
<input id="lang" type="hidden" value="<?php print substr($_SESSION['locale'], 0,2)?>">
<input id="login_user" type="hidden" value="<?php print $_SESSION['username'] ?>">
<input id="is_admin" type="hidden" value="<?php print $_SESSION['is_admin'] ?>">
<?php } ?>