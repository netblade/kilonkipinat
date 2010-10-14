<?php
$prefix = $data['prefix'];
$todos = $data['todoitems'];
$filters = $data['filters'];
?>

<h1>Kaikki nakit</h1>
<div class="fi_kilonkipinat_website_toggler_container" id="fi_kilonkipinat_todos_list_all_filters_container">
    <h2><a href="#" class="fi_kilonkipinat_website_toggler_trigger" onclick="return false;">Filteröi</a></h2>
    <div class="fi_kilonkipinat_website_toggler_content"<?php if (count($filters) == 0) { echo ' style="display: none;"';} ?>>
        <form method="GET">
            <div class="fi_kilonkipinat_todos_list_all_filters_filter">
                <label for="fi_kilonkipinat_todos_todoitem_filter_status">Status</label>
                <select id="fi_kilonkipinat_todos_todoitem_filter_status" name="fi_kilonkipinat_todos_todoitem_filter_status[]" multiple="multiple" class="fi_kilonkipinat_todos_list_all_filters_filter_select_multiple">
                    <option<?php if (isset($filters['filter_status']) && in_array(FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_NEW, $filters['filter_status'])) { echo ' selected="selected"'; } ?> value="<?php echo FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_NEW; ?>"><?php echo $_MIDCOM->i18n->get_string('short_status_' . FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_NEW, 'fi.kilonkipinat.todos'); ?></option>
                    <option<?php if (isset($filters['filter_status']) && in_array(FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_PENDING, $filters['filter_status'])) { echo ' selected="selected"'; } ?> value="<?php echo FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_PENDING; ?>"><?php echo $_MIDCOM->i18n->get_string('short_status_' . FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_PENDING, 'fi.kilonkipinat.todos'); ?></option>
                    <option<?php if (isset($filters['filter_status']) && in_array(FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_ACKNOWLEDGED, $filters['filter_status'])) { echo ' selected="selected"'; } ?> value="<?php echo FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_ACKNOWLEDGED; ?>"><?php echo $_MIDCOM->i18n->get_string('short_status_' . FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_ACKNOWLEDGED, 'fi.kilonkipinat.todos'); ?></option>
                    <option<?php if (isset($filters['filter_status']) && in_array(FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_RESOLVED, $filters['filter_status'])) { echo ' selected="selected"'; } ?> value="<?php echo FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_RESOLVED; ?>"><?php echo $_MIDCOM->i18n->get_string('short_status_' . FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_RESOLVED, 'fi.kilonkipinat.todos'); ?></option>
                    <option<?php if (isset($filters['filter_status']) && in_array(FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_CLOSED, $filters['filter_status'])) { echo ' selected="selected"'; } ?> value="<?php echo FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_CLOSED; ?>"><?php echo $_MIDCOM->i18n->get_string('short_status_' . FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_CLOSED, 'fi.kilonkipinat.todos'); ?></option>
                </select>
            </div>
            <div class="fi_kilonkipinat_todos_list_all_filters_filter">
                <label for="fi_kilonkipinat_todos_todoitem_filter_person">Henkilöt</label>
                <select id="fi_kilonkipinat_todos_todoitem_filter_person" name="fi_kilonkipinat_todos_todoitem_filter_person[]" multiple="multiple" class="fi_kilonkipinat_todos_list_all_filters_filter_select_multiple">
                    <?php
                    foreach ($data['persons'] as $person) {
                    ?>
                    <option<?php if (isset($filters['filter_person']) && in_array($person['id'], $filters['filter_person'])) { echo ' selected="selected"'; } ?> value="<?php echo $person['id']; ?>"><?php echo $person['nickname'] . ' ('.$person['firstname'] . ' ' . $person['lastname'].')'; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="fi_kilonkipinat_todos_list_all_filters_filter">
                <label for="fi_kilonkipinat_todos_todoitem_filter_limit">Näytä</label>
                <select id="fi_kilonkipinat_todos_todoitem_filter_limit" name="fi_kilonkipinat_todos_todoitem_filter_limit" class="fi_kilonkipinat_todos_list_all_filters_filter_select">
                    <option<?php if (isset($filters['filter_limit']) && $filters['filter_limit'] == '10') { echo ' selected="selected"'; } ?> value="10">10</option>
                    <option<?php if (isset($filters['filter_limit']) && $filters['filter_limit'] == '20') { echo ' selected="selected"'; } ?> value="10">20</option>
                    <option<?php if (isset($filters['filter_limit']) && $filters['filter_limit'] == '50') { echo ' selected="selected"'; } ?> value="50">50</option>
                </select>
            </div>
            <div class="clearer_left">&nbsp;</div><br />
            <input type="submit" value="Filteröi" />
        </form>
    </div>
</div>
<?php
if (count($todos)>0) {
    echo "<table class=\"tablesorter\">\n";
    echo "\t<thead>\n";
    echo "\t\t<tr>\n";
    echo "\t\t\t<th class=\"header\">Otsikko</th>\n";
    echo "\t\t\t<th class=\"{sorter: 'fiDate'} header\">Parasta ennen</th>\n";
    echo "\t\t\t<th class=\"header\">Status</th>\n";
    echo "\t\t\t<th class=\"header\">Nakitettava</th>\n";
    echo "\t\t\t<th class=\"header\">Nakittaja</th>\n";
    echo "\t\t\t<th class=\"header\">Paino</th>\n";
    echo "\t\t\t<th class=\"header\">Ryhmä</th>\n";
    echo "\t\t\t<th class=\"header\">Tapahtuma</th>\n";
    echo "\t\t</tr>\n";
    echo "\t</thead>\n";
    foreach ($todos as $todo) {
        echo "\t\t<tr>\n";
//        echo "\t\t\t<td><a href=\"".$prefix.'view_todo/'.$todo->guid."\">".$todo->title."</a></td>\n";
        echo "\t\t\t<td><a class=\"fi_kilonkipinat_todos_todoitem_modal_link\" href=\"#" . $todo->guid."\">".$todo->title."</a></td>\n";
        echo "\t\t\t<td>".fi_kilonkipinat_website::returnDate(strtotime($todo->deadline), 'short')."</td>\n";
        echo "\t\t\t<td>" . $_MIDCOM->i18n->get_string('status_' . $todo->status, 'fi.kilonkipinat.todos') . "</td>\n";
        echo "\t\t\t<td>";
        if ($todo->person != 0) {
            $person = new fi_kilonkipinat_account_person_dba($todo->person);
            if ($person->id == $todo->person) {
                echo '<a href="/extranet/nettisivut/kayttajat/person/view/' . $person->guid . '/" title="' . $person->firstname .' ' . $person->lastname . '">' . $person->nickname . '</a>'."";
            } else {
                echo "&nbsp;";
            }
        } else {
            echo "&nbsp;";
        }
        echo "</td>\n";
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
        echo "</td>\n";
        echo "\t\t\t<td>".$_MIDCOM->i18n->get_string('weight_'.$todo->weight, 'fi.kilonkipinat.todos')."</td>\n";
        echo "\t\t\t<td>";
        if ($todo->grp != 0) {
            $grp = new midcom_db_group($todo->grp);
            if ($grp->id == $todo->grp) {
                echo $grp->official;
            } else {
                echo "&nbsp;";
            }
        } else {
            echo "&nbsp;";
        }
        echo "</td>\n";
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
        echo "</td>\n";
        echo "\t\t</tr>\n";
    }
    echo "</table>\n";

    $data['qb']->show_pages();
} else {
    echo "<p>Ei nakkeja</p>";
}
?>