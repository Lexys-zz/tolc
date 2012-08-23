<!-- Admin mode ------------------------------------------------------------ -->
<input id="must_change_passwd" type="hidden"
	   value="<?php print $_SESSION['must_change_passwd'] ? '1' : '0' ?>">

<input id="tinymce_url" type="hidden" value="<?php print TINYMCE_URL ?>">
<input id="content_css_url" type="hidden"
	   value="<?php print $tolc_conf['project_url'] . $template_path . $css_url ?>">
<input id="ezfilemanager_url" type="hidden"
	   value="<?php print EZFILEMANAGER_URL ?>">
<input id="lang" type="hidden"
	   value="<?php print substr($_SESSION['locale'], 0, 2)?>">
<input type="hidden" id="base_url" value="<?php print CONST_BASE_URL ?>">
<input type="hidden" id="active_elements"
	   value="<?php print $active_elements ?>">

<input type="hidden" id="rsc_help_toggle"
	   value="<?php print gettext('help') ?>">
<input type="hidden" id="btn_ok" value="<?php print gettext('Ok') ?>">
<input type="hidden" id="btn_save" value="<?php print gettext('Save') ?>">
<input type="hidden" id="btn_cancel" value="<?php print gettext('Cancel') ?>">
<input type="hidden" id="rsc_edit" value="<?php print gettext('Edit') ?>">
<input type="hidden" id="rsc_whole_page" value="<?php print gettext('whole page') ?>">

<input type="hidden" id="rsc_password_charset"
	   value="<?php print $tolc_conf['pref_password_charset'] ?>">
<input type="hidden" id="rsc_username_charset"
	   value="<?php print $tolc_conf['pref_username_charset'] ?>">
<input type="hidden" id="rsc_password_minchars"
	   value="<?php print $tolc_conf['pref_password_minchars'] ?>">
<input type="hidden" id="rsc_password_maxchars"
	   value="<?php print $tolc_conf['pref_password_maxchars'] ?>">
<input type="hidden" id="rsc_suggested_password_length"
	   value="<?php print $tolc_conf['pref_suggested_password_length'] ?>">

<input type="hidden" id="rsc_password_mask"
	   value="<?php print gettext('Mask') ?>">
<input type="hidden" id="rsc_password_unmask"
	   value="<?php print gettext('Unmask') ?>">
<input type="hidden" id="msg_username_required"
	   value="<?php print gettext('Username is required') . '...' ?>">
<input type="hidden" id="msg_old_password_required"
	   value="<?php print gettext('Old password is required') . '...' ?>">
<input type="hidden" id="msg_new_password_required"
	   value="<?php print gettext('New password is required') . '...' ?>">
<input type="hidden" id="msg_password_verification_required"
	   value="<?php print gettext('Please, repeat the new password') . '...' ?>">
<input type="hidden" id="msg_user_fullname_required"
	   value="<?php print gettext('User fullname is required') . '...' ?>">
<input type="hidden" id="msg_user_email_required"
	   value="<?php print gettext('User email is required') . '...' ?>">

<input type="hidden" id="www_pages_id"
	   value="<?php print $www_pages_id ?>">
<input type="hidden" id="page_has_been_removed"
	   value="<?php print $page_has_been_removed ?>">

<div id="about_tolc_form" title="<?php print gettext('About')?>">
</div>

<div id="user_form"
	 title="<?php print $_SESSION['must_change_passwd'] ? gettext('Change password') : gettext('User profile') ?>">
</div>