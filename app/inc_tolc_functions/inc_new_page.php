<!-- New page -------------------------------------------------------------- -->
<input type="hidden" id="btn_do_new_page" value="<?php print gettext('Create') ?>">
<input type="hidden" id="btn_cancel_new_page" value="<?php print gettext('Cancel') ?>">
<input type="hidden" id="msg_page_url_required" value="<?php print gettext('Page URL is required') . '...' ?>">
<input type="hidden" id="msg_page_title_required" value="<?php print gettext('Page title is required') . '...' ?>">
<input type="hidden" id="msg_template_required" value="<?php print gettext('Page template is required') . '...' ?>">
<input type="hidden" id="msg_date_start_required" value="<?php print gettext('Starting date is required') . '...' ?>">
<input type="hidden" id="msg_parent_required" value="<?php print gettext('Please, select the parent page (title or URL)') . '...' ?>">

<div id="new_page_form" title="<?php print gettext('New page')?>">
</div>

<input id="dateformat" type="hidden"
	   value="<?php print $a_date_format[$_SESSION['user_dateformat']]['jq_date'] ?>">
<input id="timeformat" type="hidden"
	   value="<?php print $a_date_format[$_SESSION['user_dateformat']]['jq_time'] ?>">
<input id="pref_tinymce_toggle_toolbar" type="hidden"
	   value="<?php print $tolc_conf['pref_tinymce_toggle_toolbar'] ? '1' : '0' ?>">