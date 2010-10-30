<?php
if (!$_MIDGARD['user']) {
    die('No User, exiting!');
}
if (   !isset($_POST)
    || !is_array($_POST)
    || !isset($_POST['todoitem_guid'])
    || !isset($_POST['new_status'])) {
    die('No Post or guid, exiting!');
}

$todo = new fi_kilonkipinat_todos_todoitem_dba($_POST['todoitem_guid']);

switch ($_POST['new_status']) {
    case 'new':
        $todo->status = FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_NEW;
        $GLOBALS['fi.kilonkipinat.todos_update_message'] = "Nakin tilaksi vaihdettiin 'uusi'";
    break;
    case 'pending':
        $todo->status = FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_PENDING;
        $GLOBALS['fi.kilonkipinat.todos_update_message'] = "Nakin tilaksi vaihdettiin 'odottaa'";
    break;
    case 'acknowledged':
        $todo->status = FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_ACKNOWLEDGED;
        $GLOBALS['fi.kilonkipinat.todos_update_message'] = "Nakin tilaksi vaihdettiin 'työn alla'";
    break;
    case 'resolved':
        $todo->status = FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_RESOLVED;
        $GLOBALS['fi.kilonkipinat.todos_update_message'] = "Nakin tilaksi vaihdettiin 'kunnossa'";
    break;
    case 'closed':
        $todo->status = FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_CLOSED;
        $GLOBALS['fi.kilonkipinat.todos_update_message'] = "Nakin tilaksi vaihdettiin 'suljettu'";
    break;
    default:
        die();
    break;
}

$todo->update();
die();

?>