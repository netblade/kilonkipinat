<?php
$prefix = $data['prefix'];

$todo = $data['object'];

?>
<h1>Nakki: &(todo.title:h);</h1>
<div id="fi_kilonkipinat_todos_todoitem_details">
    Parasta ennen: <?php echo fi_kilonkipinat_website::returnDate(strtotime($todo->deadline), 'short'); ?><br />
    Valmistettu: <?php echo fi_kilonkipinat_website::returnDate($todo->metadata->created, 'short'); ?><br />
    Paino: <?php $_MIDCOM->i18n->show_string('weight_'.$todo->weight, 'fi.kilonkipinat.todos'); ?>
</div>
<div id="fi_kilonkipinat_todos_todoitem_content">
    <h4>Kuvaus</h4>
    &(todo.content:h);
</div>
<div id="fi_kilonkipinat_todos_todoitem_info">
<?php
if ($todo->person != 0) {
    $person = new fi_kilonkipinat_account_person_dba($todo->person);
    if ($person->id == $todo->person) {
        $person_str = '<a href="/extranet/nettisivut/kayttajat/person/view/' . $person->guid . '/" title="' . $person->firstname .' ' . $person->lastname . '">' . $person->nickname . '</a>';
?>
    Nakitettu: &(person_str:h);<br />
<?php
    }
} elseif ($todo->grp != 0) {
    $group = new midcom_db_group($todo->grp);
    if ($group->id == $todo->grp) {
        $group_str = $group->official;
?>
    Nakitettu ryhmä: &(group_str:h);<br />
<?php
    }
}
if ($todo->supervisor != 0) {
    $supervisor = new fi_kilonkipinat_account_person_dba($todo->supervisor);
    if ($supervisor->id == $todo->supervisor) {
        $supervisor_str = '<a href="/extranet/nettisivut/kayttajat/person/view/' . $supervisor->guid . '/" title="' . $supervisor->firstname .' ' . $supervisor->lastname . '">' . $supervisor->nickname . '</a>';
?>
    Valvoja: &(supervisor_str:h);<br />
<?php
    }
}
if ($todo->event != 0) {
    $event = new fi_kilonkipinat_events_event_dba($todo->event);
    if ($event->id == $todo->event) {
        $event_str = '<a href="/midcom-permalink-' . $event->guid . '/" title="' . $event->title .'">' . $event->title . '</a>';
?>
    Tapahtuma: &(event_str:h);<br />
<?php
    }
}
if (   !isset($supervisor)
    || $supervisor->guid != $todo->metadata->creator) {
    $creator = new fi_kilonkipinat_account_person_dba($todo->metadata->creator);
    if ($creator->id == $todo->metadata->creator) {
        $creator_str = '<a href="/extranet/nettisivut/kayttajat/person/view/' . $creator->guid . '/" title="' . $creator->firstname .' ' . $creator->lastname . '">' . $creator->nickname . '</a>';
?>
    Nakin luoja: &(creator_str:h);<br />
<?php
    }
}
?>
</div>