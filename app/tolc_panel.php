<?php
// prevent direct access
if(!$tolc_include) {
	echo 'Access denied!';
	exit;
}
?>
<?php if(isset($_SESSION['username'])) { ?>
<!-- tolc panel (included by tolc) ----------------------------------------- -->
<?php
	// retrieve is_admin
	$sql = 'SELECT is_admin FROM www_users WHERE username=' . $conn->qstr($_SESSION['username']);
	$rs = $conn->Execute($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
	}
	$is_admin = $rs->fields['is_admin'] == 1 ? true : false;
	?>
<div id="tolc_panel">
	<a id="login_user"><?php print $_SESSION['username']?></a>
	<a id="tp_edit_page" class="tolc_panel_btn"
	   href="javascript:void(0);"><?php print gettext('Page properties') ?></a>
	<a id="tp_sitemap" class="tolc_panel_btn"
	   href="javascript:void(0);"><?php print gettext('Sitemap') ?></a>
	<a id="tp_templates" class="tolc_panel_btn"
	   href="javascript:void(0);"><?php print gettext('Templates') ?></a>
	<a id="tp_filemanager" class="tolc_panel_btn"
	   href="javascript:void(0);"><?php print gettext('Files') ?></a>

	<?php if($is_admin) { ?>
	|
	<a id="tp_users" class="tolc_panel_btn"
	   href="javascript:void(0);"><?php print gettext('Users') ?></a>
	<?php } ?>
	|
	<a id="tp_logout" class="tolc_panel_btn"
	   href="javascript:void(0);"><?php print gettext('Logout') ?></a>
	|
	<a id="tp_about" class="tolc_panel_btn"
	   href="javascript:void(0);"><?php print gettext('About Tolc') ?></a>
</div>

<div id="tolc_slide">
	<a id="tolc_btn_slide"
	   href="javascript:void(0);"
	   title="<?php print gettext('Show/Hide Admin Panel') ?>">
		<?php print gettext('Show/Hide Admin Panel') ?>
	</a>
</div>
<?php } ?>
