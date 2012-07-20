<!-- Admin mode ------------------------------------------------------------ -->
<input id="tinymce_url" type="hidden" value="<?php print TINYMCE_URL ?>">
<input id="content_css_url" type="hidden"
	   value="<?php print $tolc_conf['project_url'] . $template_path . $css_url ?>">
<input id="ezfilemanager_url" type="hidden"
	   value="<?php print EZFILEMANAGER_URL ?>">
<input id="lang" type="hidden"
	   value="<?php print substr($_SESSION['locale'], 0, 2)?>">
<input type="hidden" id="base_url" value="<?php print $tolc_conf['base_url'] ?>">
<input type="hidden" id="active_elements"
	   value="<?php print $active_elements ?>">