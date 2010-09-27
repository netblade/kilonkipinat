<?php
$prefix = $data['prefix'];
?>

<h1>Nakit</h1>

<div class="fi_kilonkipinat_website_toggler_container">
<?php
$qb_my = fi_kilonkipinat_todos_todoitem_dba::new_query_builder();
$qb_my->add_constraint('person', '=', $_MIDGARD['user']);
$qb_my->add_order('deadline', 'ASC');
$qb_my->set_limit(5);
$todos_my = $qb_my->execute();
?>
<h2><a href="#" class="fi_kilonkipinat_website_toggler_trigger" onclick="return false;">Mulle nakitetut (<?php echo count($todos_my); ?>)</a></h2>
<div class="fi_kilonkipinat_website_toggler_content" style="display: none;">
<?php
if (count($todos_my)>0) {
    echo "<table class=\"tablesorter\">\n";
    echo "\t<thead>";
    echo "\t\t<tr>";
    echo "\t\t\t<th class=\"header\">Otsikko</th>";
    echo "\t\t\t<th class=\"{sorter: 'fiDate'} header\">Parasta ennen</th>";
    echo "\t\t\t<th class=\"header\">Nakittaja</th>";
    echo "\t\t\t<th class=\"header\">Paino</th>";
    echo "\t\t\t<th class=\"header\">Tapahtuma</th>";
    echo "\t\t</tr>";
    echo "\t</thead>";
    foreach ($todos_my as $todo) {
        echo "\t\t<tr>";
        echo "\t\t\t<td><a href=\"".$prefix.'view_todo/'.$todo->guid."\">".$todo->title."</a></td>";
        echo "\t\t\t<td>".fi_kilonkipinat_website::returnDate(strtotime($todo->deadline), 'short')."</td>";
        echo "\t\t\t<td>";
        if ($todo->supervisor != 0) {
            $supervisor = new fi_kilonkipinat_account_person_dba($todo->supervisor);
            if ($supervisor->id == $todo->supervisor) {
                echo '<a href="/extranet/nettisivut/kayttajat/person/view/' . $supervisor->guid . '/" title="' . $supervisor->firstname .' ' . $supervisor->lastname . '">' . $supervisor->nickname . '</a>';
            } else {
                echo "&nbsp;";
            }
        } else {
            echo "&nbsp;";
        }
        echo "</td>";
        echo "\t\t\t<td>".$_MIDCOM->i18n->get_string('weight_'.$todo->weight, 'fi.kilonkipinat.todos')."</td>";
        echo "\t\t\t<td>";
        if ($todo->event != 0) {
            $event = new fi_kilonkipinat_events_event_dba($todo->event);
            if ($event->id == $todo->event) {
                echo '<a href="/midcom-permalink-' . $event->guid . '/" title="' . $event->title .'">' . $event->title . '</a>';
            } else {
                echo "&nbsp;";
            }
        } else {
            echo "&nbsp;";
        }
        echo "</td>";
        echo "\t\t</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Ei nakkeja</p>";
}
?>
</div>
</div>

<div class="fi_kilonkipinat_website_toggler_container">
<?php
$my_groups = array();
$mc_my_groups = midcom_db_member::new_collector('sitegroup', $_MIDGARD['sitegroup']);
$mc_my_groups->add_constraint('uid', '=', $_MIDGARD['user']);
$mc_my_groups->add_value_property('gid');
$mc_my_groups->execute();
$tmp_keys = $mc_my_groups->list_keys();

foreach ($tmp_keys as $guid => $tmp_key)
{
    $group_id = $mc_my_groups->get_subkey($guid, 'gid');
    $my_groups[$group_id] = $group_id;
}

$qb_my_groups = fi_kilonkipinat_todos_todoitem_dba::new_query_builder();
$qb_my_groups->add_constraint('grp', 'IN', $my_groups);
$qb_my_groups->add_constraint('grp', '<>', 0);
$qb_my_groups->add_order('deadline', 'ASC');
$qb_my_groups->set_limit(5);
$todos_my_groups = $qb_my_groups->execute();
?>
<h2><a href="#" class="fi_kilonkipinat_website_toggler_trigger" onclick="return false;">Mun ryhmille nakitetut (<?php echo count($todos_my_groups); ?>)</a></h2>
<div class="fi_kilonkipinat_website_toggler_content" style="display: none;">
<?php
if (count($todos_my_groups)>0) {
    echo "<table class=\"tablesorter\">\n";
    echo "\t<thead>";
    echo "\t\t<tr>";
    echo "\t\t\t<th class=\"header\">Otsikko</th>";
    echo "\t\t\t<th class=\"{sorter: 'fiDate'} header\">Parasta ennen</th>";
    echo "\t\t\t<th class=\"header\">Nakittaja</th>";
    echo "\t\t\t<th class=\"header\">Paino</th>";
    echo "\t\t\t<th class=\"header\">Tapahtuma</th>";
    echo "\t\t</tr>";
    echo "\t</thead>";
    foreach ($todos_my_groups as $todo) {
        echo "\t\t<tr>";
        echo "\t\t\t<td><a href=\"".$prefix.'view_todo/'.$todo->guid."\">".$todo->title."</a></td>";
        echo "\t\t\t<td>".fi_kilonkipinat_website::returnDate(strtotime($todo->deadline), 'short')."</td>";
        echo "\t\t\t<td>";
        if ($todo->supervisor != 0) {
            $supervisor = new fi_kilonkipinat_account_person_dba($todo->supervisor);
            if ($supervisor->id == $todo->supervisor) {
                echo '<a href="/extranet/nettisivut/kayttajat/person/view/' . $supervisor->guid . '/" title="' . $supervisor->firstname .' ' . $supervisor->lastname . '">' . $supervisor->nickname . '</a>';
            } else {
                echo "&nbsp;";
            }
        } else {
            echo "&nbsp;";
        }
        echo "</td>";
        echo "\t\t\t<td>".$_MIDCOM->i18n->get_string('weight_'.$todo->weight, 'fi.kilonkipinat.todos')."</td>";
        echo "\t\t\t<td>";
        if ($todo->event != 0) {
            $event = new fi_kilonkipinat_events_event_dba($todo->event);
            if ($event->id == $todo->event) {
                echo '<a href="/midcom-permalink-' . $event->guid . '/" title="' . $event->title .'">' . $event->title . '</a>';
            } else {
                echo "&nbsp;";
            }
        } else {
            echo "&nbsp;";
        }
        echo "</td>";
        echo "\t\t</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Ei nakkeja</p>";
}
?>
</div>
</div>

<div class="fi_kilonkipinat_website_toggler_container">
<?php
$qb_my_supervised = fi_kilonkipinat_todos_todoitem_dba::new_query_builder();
$qb_my_supervised->add_constraint('supervisor', '=', $_MIDGARD['user']);
$qb_my_supervised->add_order('deadline', 'ASC');
$qb_my_supervised->set_limit(5);
$todos_my_supervised = $qb_my_supervised->execute();
?>
<h2><a href="#" class="fi_kilonkipinat_website_toggler_trigger" onclick="return false;">Minä valvojana (<?php echo count($todos_my_supervised); ?>)</a></h2>
<div class="fi_kilonkipinat_website_toggler_content" style="display: none;">
<?php
if (count($todos_my_supervised)>0) {
    echo "<table class=\"tablesorter\">\n";
    echo "\t<thead>";
    echo "\t\t<tr>";
    echo "\t\t\t<th class=\"header\">Otsikko</th>";
    echo "\t\t\t<th class=\"{sorter: 'fiDate'} header\">Parasta ennen</th>";
    echo "\t\t\t<th class=\"header\">Nakitettu</th>";
    echo "\t\t\t<th class=\"header\">Paino</th>";
    echo "\t\t\t<th class=\"header\">Tapahtuma</th>";
    echo "\t\t</tr>";
    echo "\t</thead>";
    foreach ($todos_my_supervised as $todo) {
        echo "\t\t<tr>";
        echo "\t\t\t<td><a href=\"".$prefix.'view_todo/'.$todo->guid."\">".$todo->title."</a></td>";
        echo "\t\t\t<td>".fi_kilonkipinat_website::returnDate(strtotime($todo->deadline), 'short')."</td>";
        echo "\t\t\t<td>";
        if ($todo->person != 0) {
            $person = new fi_kilonkipinat_account_person_dba($todo->person);
            if ($person->id == $todo->person) {
                echo '<a href="/extranet/nettisivut/kayttajat/person/view/' . $person->guid . '/" title="' . $person->firstname .' ' . $person->lastname . '">' . $person->nickname . '</a>';
            } else {
                echo "&nbsp;";
            }
        } else {
            echo "&nbsp;";
        }
        echo "</td>";
        echo "\t\t\t<td>".$_MIDCOM->i18n->get_string('weight_'.$todo->weight, 'fi.kilonkipinat.todos')."</td>";
        echo "\t\t\t<td>";
        if ($todo->event != 0) {
            $event = new fi_kilonkipinat_events_event_dba($todo->event);
            if ($event->id == $todo->event) {
                echo '<a href="/midcom-permalink-' . $event->guid . '/" title="' . $event->title .'">' . $event->title . '</a>';
            } else {
                echo "&nbsp;";
            }
        } else {
            echo "&nbsp;";
        }
        echo "</td>";
        echo "\t\t</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Ei nakkeja</p>";
}
?>
</div>
</div>