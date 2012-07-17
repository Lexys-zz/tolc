<?php
// prevent direct access
if(!$tolc_include) {
    echo 'Access denied!';
    exit;
}
?>
<!-- ----------------- Included by TOLC to <HEAD> (start) ------------------ -->
<link rel="shortcut icon" href="<?php print PROJECT_URL . $template_path ?>favicon.ico" />

<link href="<?php print JQUERY_UI_CSS_URL ?>" rel="stylesheet" type="text/css" />

<?php if (!$admin_mode && $login) { ?>
<link href="<?php print PROJECT_URL ?>/app/login/login.css?version=6" rel="stylesheet" type="text/css" />
<?php } ?>

<?php if ($admin_mode) { ?>
<link href="<?php print JQUERY_UI_LAYOUT_CSS_URL ?>" rel="stylesheet" type="text/css" />
<link href="<?php print QTIP2_CSS_URL ?>" rel="stylesheet" type="text/css" />
<link href="<?php print PROJECT_URL ?>/app/admin/admin.css" rel="stylesheet" type="text/css" />
<?php } ?>

<script type="text/javascript" src="<?php print JQUERY_URL ?>"></script>
<script type="text/javascript" src="<?php print JQUERY_UI_URL ?>"></script>

<?php if ($admin_mode) { ?>
<script type="text/javascript" src="<?php print JQUERY_UI_EXT_AUTOCOMPLETE_HTML_URL ?>"></script>
<script type="text/javascript" src="<?php print JQUERY_UI_LAYOUT_URL ?>"></script>
<script type="text/javascript" src="<?php print JSTREE_URL ?>"></script>
<script type="text/javascript" src="<?php print QTIP2_URL ?>"></script>
<?php } ?>

<script type="text/javascript" src="<?php print PROJECT_URL ?>/app/common/utils.js?version=1"></script>

<script type="text/javascript" src="<?php print PROJECT_URL ?>/app/index.js?version=4"></script>

<?php if (!$admin_mode && $login) { ?>
<script type="text/javascript" src="<?php print PROJECT_URL ?>/app/login/login.js?version=5"></script>
<?php } ?>

<?php if ($admin_mode) { ?>
<script type="text/javascript" src="<?php print PROJECT_URL ?>/app/admin/admin.js?version=1"></script>
<?php } ?>
<!-- ------------------ Included by TOLC to <HEAD> (end) ------------------- -->