<?php
$prefix = $data['prefix'];
$todos = $data['todoitems'];
?>

<h1>Mulle nakitetut</h1>
<?php
if (count($todos)>0) {
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
    foreach ($todos as $todo) {
        echo "\t\t<tr>";
//        echo "\t\t\t<td><a href=\"".$prefix.'view_todo/'.$todo->guid."\">".$todo->title."</a></td>\n";
        echo "\t\t\t<td><a class=\"fi_kilonkipinat_todos_todoitem_modal_link\" href=\"#" . $todo->guid."\">".$todo->title."</a></td>\n";
        echo "\t\t\t<td>".fi_kilonkipinat_website::returnDate(strtotime($todo->deadline), 'short')."</td>";
        echo "\t\t\t<td>";
        if ($todo->supervisor != 0) {
            $supervisor = new fi_kilonkipinat_account_person_dba($todo->supervisor);
            if ($supervisor->id == $todo->supervisor) {
				if ($supervisor->nickname != '') {
					$nickname = $supervisor->nickname;
				} else {
					$nickname = $supervisor->firstname . ' ' . $supervisor->lastname;
				}
                echo '<a href="/extranet/nettisivut/kayttajat/person/view/' . $supervisor->guid . '/" title="' . $supervisor->firstname .' ' . $supervisor->lastname . '">' . $nickname . '</a>';
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

    $data['qb']->show_pages();
} else {
    echo "<p>Ei nakkeja</p>";
}
?>