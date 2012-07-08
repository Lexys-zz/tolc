<link rel="shortcut icon" href="<?php print TEMPLATE_URL ?>favicon.ico" />

<link href="<?php print JQUERY_UI_CSS_URL ?>" rel="stylesheet" type="text/css" />

<?php if (!$admin_mode && $login) { ?>
<link href="<?php print PROJECT_URL ?>/app/login.css?version=5" rel="stylesheet" type="text/css" />
<?php } ?>

<?php if ($admin_mode) { ?>
<link href="<?php print JQUERY_UI_LAYOUT_CSS_URL ?>" rel="stylesheet" type="text/css" />
<link href="<?php print PROJECT_URL ?>/app/common/tolc_panel.css" rel="stylesheet" type="text/css" />
<?php } ?>

<script type="text/javascript" src="<?php print JQUERY_URL ?>"></script>
<script type="text/javascript" src="<?php print JQUERY_UI_URL ?>"></script>

<?php if ($admin_mode) { ?>
<script type="text/javascript" src="<?php print JQUERY_UI_EXT_AUTOCOMPLETE_HTML_URL ?>"></script>
<script type="text/javascript" src="<?php print JQUERY_UI_LAYOUT_URL ?>"></script>
<script type="text/javascript" src="<?php print JSTREE_URL ?>"></script>
<?php } ?>

<script type="text/javascript" src="<?php print PROJECT_URL ?>/app/index.js?version=3"></script>

<?php if (!$admin_mode && $login) { ?>
<script type="text/javascript" src="<?php print PROJECT_URL ?>/app/login.js?version=2"></script>
<?php } ?>

<?php if ($admin_mode) { ?>
<script type="text/javascript" src="<?php print PROJECT_URL ?>/app/admin.js?version=1"></script>
<?php } ?>
