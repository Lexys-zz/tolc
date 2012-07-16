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

<!-- Login required -------------------------------------------------------- -->
<?php if (!$admin_mode && $new_page) { ?>
<div id="login_required_new_page"
     title="<?php print gettext('Login required')?>">
    <?php print gettext('Page does not exist. Login required to create this page') . '...' ?>
</div>
<?php } ?>

<!-- Login form ------------------------------------------------------------ -->
<?php if (!$admin_mode && $login) { ?>
<div id="login_form" title="<?php print gettext('Login')?>">
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

<!-- Already logged in ----------------------------------------------------- -->
<?php if ($admin_mode && $login) { ?>
<div id="already_login"
     title="<?php print gettext('Login')?>">
    <?php print gettext('Already logged in') . '...'; ?>
</div>
<?php } ?>

<!-- Admin mode ------------------------------------------------------------ -->
<?php if ($admin_mode) { ?>
<input id="tinymce_url" type="hidden" value="<?php print TINYMCE_URL ?>">
<input id="content_css_url" type="hidden"
       value="<?php print PROJECT_URL . $template_path . $css_url ?>">
<input id="ezfilemanager_url" type="hidden"
       value="<?php print EZFILEMANAGER_URL ?>">
<input id="lang" type="hidden"
       value="<?php print substr($_SESSION['locale'], 0, 2)?>">
<input id="login_user" type="hidden"
       value="<?php print $_SESSION['username'] ?>">
<input id="is_admin" type="hidden" value="<?php print $_SESSION['is_admin'] ?>">
<?php } ?>