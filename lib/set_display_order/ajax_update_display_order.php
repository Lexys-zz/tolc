<?php

require_once '../../common/session.php';

$ordered_ids = $_POST['ordered_ids'];
$table_name = $_POST['table_name'];
$id_field_name = $_POST['id_field_name'];
$display_order_field_name = $_POST['display_order_field_name'];

$ids = explode('|', $ordered_ids);

var_dump($ids);

$n = count($ids);
for ($i = 0; $i < $n; $i++) {
    $cur_id = $ids[$i];
    $result.=$cur_id;
    $dbi->newUpdate($table_name, OPT_AUDIT, $cur_id);
    $dbi->addField($display_order_field_name, OPT_DISPLAY_ORDER_STEP * ($i + 1));
    $dbi->addCondition($id_field_name . '=' . $dbi->qstr($cur_id));
    $res = $dbi->execute();
    if ($res === false) {
        trigger_error('Wrong SQL: ' . $dbi->lastSQL . ' Error: ' . $dbi->lastError, E_USER_ERROR);
    }
}

print $result;

?>
