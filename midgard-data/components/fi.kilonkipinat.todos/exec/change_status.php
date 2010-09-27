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
	break;
	case 'pending':
		$todo->status = FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_PENDING;
	break;
	case 'acknowledged':
		$todo->status = FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_ACKNOWLEDGED;
	break;
	case 'resolved':
		$todo->status = FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_RESOLVED;
	break;
	case 'closed':
		$todo->status = FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_CLOSED;
	break;
	default:
		die();
	break;
}

$todo->update();
die();

?>