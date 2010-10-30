<?php
if (!$_MIDGARD['user']) {
	die('No User, exiting!');
}
if (   !isset($_POST)
	|| !is_array($_POST)
	|| !isset($_POST['todoitem_guid'])) {
	die('No Post or guid, exiting!');
}

$todo = new fi_kilonkipinat_todos_todoitem_dba($_POST['todoitem_guid']);

?>
<div id="fi_kilonkipinat_todos_todoitem_info">
	<div id="fi_kilonkipinat_todos_todoitem_info_tools">
		<ul class="midcom_toolbar">
			<li class="enabled">
				<a href="/extranet/todot/edit_todo/<?php echo $todo->guid; ?>/">
					<img alt="" src="/midcom-static/stock-icons/16x16/edit.png">&nbsp;<span class="toolbar_label">Muokkaa</span>
				</a>
			</li>
<?php
$can_edit = false;
$can_supervise = false;

if ($todo->supervisor == $_MIDGARD['user']) {
	$can_supervise = true;
}

if (   $todo->person == $_MIDGARD['user']
	|| fi_kilonkipinat_todos_viewer::isInMyGroups($todo->grp)
	|| (   $todo->grp == 0
		&& $todo->person == 0)) {
	$can_edit = true;
}

if ($can_edit) {
	if (   $todo->status == FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_NEW
		|| $todo->status == FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_PENDING) {
?>
			<li class="enabled">
				<a href="#" onclick="jQuery.application.changeTodoStatus('acknowledged', '<?php echo $todo->guid; ?>'); return false;">
					<img alt="" src="/midcom-static/stock-icons/16x16/edit.png">&nbsp;<span class="toolbar_label">Vastaanota</span>
				</a>
			</li>
<?php
	}
}
if (   $can_edit
	|| $can_supervise) {
	if (   $todo->status == FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_NEW
		|| $todo->status == FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_PENDING
		|| $todo->status == FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_ACKNOWLEDGED) {
?>
			<li class="enabled">
				<a href="#" onclick="jQuery.application.changeTodoStatus('resolved', '<?php echo $todo->guid; ?>'); return false;">
					<img alt="" src="/midcom-static/stock-icons/16x16/edit.png">&nbsp;<span class="toolbar_label">Merkkaa tehdyksi</span>
				</a>
			</li>
<?php
	}
	if ($can_supervise) {
	if (   $todo->status == FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_RESOLVED) {
?>
			<li class="enabled">
				<a href="#" onclick="jQuery.application.changeTodoStatus('closed', '<?php echo $todo->guid; ?>'); return false;">
					<img alt="" src="/midcom-static/stock-icons/16x16/edit.png">&nbsp;<span class="toolbar_label">Merkkaa suljetuksi</span>
				</a>
			</li>
<?php
	}
	if (   $todo->status == FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_RESOLVED
		|| $todo->status == FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_CLOSED) {
?>
			<li class="enabled">
				<a href="#" onclick="jQuery.application.changeTodoStatus('new', '<?php echo $todo->guid; ?>'); return false;">
					<img alt="" src="/midcom-static/stock-icons/16x16/edit.png">&nbsp;<span class="toolbar_label">Merkkaa uudeksi</span>
				</a>
			</li>
<?php
		}
	}
}
?>
<?php
if ($todo->get_parameter('fi.kilonkipinat.todos:subscribe', $_MIDCOM->auth->user->guid) != '') {
?>
			<li class="enabled">
				<a href="#" onclick="jQuery.application.subscribeToTodo('<?php echo $todo->guid; ?>', '0'); return false;">
					<img alt="" src="/midcom-static/fi.kilonkipinat.website/fam/email_delete.png">&nbsp;<span class="toolbar_label">Poista seuranta</span>
				</a>
			</li>
<?php	
} else {
?>
			<li class="enabled">
				<a href="#" onclick="jQuery.application.subscribeToTodo('<?php echo $todo->guid; ?>', '1'); return false;">
					<img alt="" src="/midcom-static/fi.kilonkipinat.website/fam/email_add.png">&nbsp;<span class="toolbar_label">Seuraa nakkia</span>
				</a>
			</li>
<?php	
}
?>
		</ul>
	</div>
	<h2><?php echo $todo->title;?></h2>
	<table class="basic_list">
		<tr>
			<th>Status</th>
			<td><?php echo $_MIDCOM->i18n->get_string('status_' . $todo->status, 'fi.kilonkipinat.todos'); ?></td>
		</tr>
	<?php
	$tmp_str = '';
	if ($todo->person != 0) {
	    $person = new fi_kilonkipinat_account_person_dba($todo->person);
	    if ($person->id == $todo->person) {
?>
			<tr>
				<th>Nakitettava</th>
				<td><?php echo '<a href="/extranet/nettisivut/kayttajat/person/view/' . $person->guid . '/" title="' . $person->firstname .' ' . $person->lastname . '">' . $person->nickname . '</a>'; ?></td>
			</tr>
<?php
	    }
	}
	if ($todo->supervisor != 0) {
	    $supervisor = new fi_kilonkipinat_account_person_dba($todo->supervisor);
	    if ($supervisor->id == $todo->supervisor) {
?>
			<tr>
				<th>Valvoja</th>
				<td><?php echo '<a href="/extranet/nettisivut/kayttajat/person/view/' . $supervisor->guid . '/" title="' . $supervisor->firstname .' ' . $supervisor->lastname . '">' . $supervisor->nickname . '</a>'; ?></td>
			</tr>
<?php
	    }
	}
	if ($todo->grp != 0) {
	    $grp = new midcom_db_group($todo->grp);
	    if ($grp->id == $todo->grp) {
?>
			<tr>
				<th>Ryhmä</th>
				<td><?php echo $grp->official; ?></td>
			</tr>
<?php
	    }
	}
	?>
		<tr>
			<th>Paino</th>
			<td><?php echo $_MIDCOM->i18n->get_string('weight_'.$todo->weight, 'fi.kilonkipinat.todos'); ?></td>
		</tr>
		<tr>
			<th>Parasta ennen</th>
			<td><?php echo fi_kilonkipinat_website::returnDate(strtotime($todo->deadline), 'short'); ?></td>
		</tr>
	</table>
	<div id="fi_kilonkipinat_todos_todoitem_info_content">
		<strong>Kuvaus:</strong> <?php echo $todo->content; ?>
	</div>
	<?php
	// No comments topic specified, autoprobe
       $comments_node = midcom_helper_find_node_by_component('net.nehmer.comments');

	if ($comments_node)
	{
	    $comments_url = $comments_node[MIDCOM_NAV_RELATIVEURL] . "comment/{$todo->guid}";
	}
	?>
	<div id="fi_kilonkipinat_todos_todoitem_comments">
	<?php
	if (isset($comments_url))
	{
	    $_MIDCOM->dynamic_load($comments_url);
	}
	?>
	</div>
</div>