<!-- Login required -------------------------------------------------------- -->
<input type="hidden" id="btn_ok" value="<?php print gettext('Ok') ?>">

<div id="login_required_new_page"
	 title="<?php print gettext('Page not found'); ?>">
	<?php print gettext('Page not found') . '.' . ' ' ?><a id="login_required" href="<?php print CONST_PROJECT_HOST . $tolc_conf['pref_reserved_urls']['login'] ?>"><?php print gettext('Login required to create this page') ?></a>...
</div>