<?php
require_once '../../common/session.php';
$action_title = localize('Display order');
include PROJECT_DIR . '/common/header_no_scripts.php';

// get vars
$data_to_order = $_GET['data_to_order'];
$a_data_to_order = unserialize(base64_decode($data_to_order));
$items = count($a_data_to_order);

$table = $_GET['table'];

$id = $_GET['id'];
if (!isset($_GET['id'])) {
    $id = 'id';
}

$display_order = $_GET['display_order'];
if (!isset($_GET['display_order'])) {
    $display_order = 'display_order';
}

$function_to_call = $_GET['function_to_call'];
?>

<link href="<?php print PROJECT_URL ?>/lib/set_display_order/index.css?version=1" rel="stylesheet" type="text/css">
<link href="<?php print JQUERY_UI_CSS_URL ?>" rel="stylesheet" type="text/css">

<script type="text/javascript" src="<?php print JQUERY_URL ?>"></script>
<script type="text/javascript" src="<?php print JQUERY_UI_URL ?>"></script>
<script type="text/javascript" src="<?php print PROJECT_URL ?>/lib/set_display_order/index.js?version=3"></script>

</head>
<body>

<div id="header_container" style="margin: auto; text-align: center;">
    <h1><?php print $action_title ?></h1>
</div>

<div id="help" style="margin-left: auto; margin-right: auto; margin-top: 10px; margin-bottom: 10px; text-align: center;">
    <h3><?php print '<strong>' . $items . ' ' . localize('records') . '.' . '</strong>' ?></h3>

    <h3><?php print localize('Click and drag to any position') ?></h3>
</div>

<div id="tools_top" style="font-size: 12px; margin-left: auto; margin-right: auto; margin-top: 10px; margin-bottom: 10px; text-align: center;">
    <a id="btn_sort_top" href="javascript:void(0);" onclick="DoSort();" style="margin-right: 10px;"><?php print localize('Save') ?></a>
    <a id="btn_close_top" href="javascript:void(0);" onclick="DoClose();" style="margin-left: 10px;"><?php print localize('Close') ?></a>
</div>

<div id="list_items">
    <ul id="sortable">
        <?php foreach ($a_data_to_order as $row) { ?>
        <li id="<?php print $row["id"] ?>" class="ui-state-default"><?php print $row["description"] ?></li>
        <?php } ?>
    </ul>
</div>

<div id="tools_bottom" style="font-size: 12px; margin-left: auto; margin-right: auto; margin-top: 10px; text-align: center;">
    <a id="btn_sort_bottom" href="javascript:void(0);" onclick="DoSort();" style="margin-right: 10px;"><?php print localize('Save') ?></a>
    <a id="btn_close_bottom" href="javascript:void(0);" onclick="DoClose();" style="margin-left: 10px;"><?php print localize('Close') ?></a>
</div>

<input type="hidden" id="table_name" name="table_name" value="<?php print $table ?>">
<input type="hidden" id="id_field_name" name="id_field_name" value="<?php print $id ?>">
<input type="hidden" id="display_order_field_name" name="display_order_field_name" value="<?php print $display_order ?>">
<input type="hidden" id="function_to_call" name="function_to_call" value="<?php print $function_to_call ?>">

</body>
</html>
