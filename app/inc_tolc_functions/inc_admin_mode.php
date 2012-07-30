<!-- Admin mode ------------------------------------------------------------ -->
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
<input type="hidden" id="btn_ok" value="<?php print gettext('Ok') ?>">
<input type="hidden" id="btn_save" value="<?php print gettext('Save') ?>">
<input type="hidden" id="btn_cancel" value="<?php print gettext('Cancel') ?>">

<input type="hidden" id="rsc_password_mask" value="<?php print gettext('Mask') ?>">
<input type="hidden" id="rsc_password_unmask" value="<?php print gettext('Unmask') ?>">

<div id="about_tolc_form" title="<?php print gettext('About')?>">
</div>

<div id="user_form" title="<?php print gettext('User profile')?>">
</div>