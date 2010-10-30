<?php
if (!$_MIDGARD['user']) {
    die('No User, exiting!');
}
if (   !isset($_POST)
    || !is_array($_POST)
    || !isset($_POST['todoitem_guid'])
    || !isset($_POST['action'])) {
    die('No Post or guid, exiting!');
}

$todo = new fi_kilonkipinat_todos_todoitem_dba($_POST['todoitem_guid']);

$person_guid = $_MIDCOM->auth->user->guid;
$now = time();

switch ($_POST['action']) {
    case '1':
        $todo->set_parameter('fi.kilonkipinat.todos:subscribe', $person_guid, $now);
    break;
    case '0':
        $todo->delete_parameter('fi.kilonkipinat.todos:subscribe', $_MIDCOM->auth->user->guid);
    break;
    default:
        die();
    break;
}
//$todo->update();
die();

?>