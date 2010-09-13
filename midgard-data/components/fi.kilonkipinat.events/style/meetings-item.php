<?php
$prefix = $data['prefix'];

$event = $data['meeting'];

$start_ts = strtotime($data['meeting']->start);
$end_ts = strtotime($data['meeting']->end);
$view_url = $prefix . 'view_event/' . $event->guid;
?>
<div class="fi_kilonkipinat_events_list_item">
    <h3><a href="&(view_url:h);">&(event.title:h);</a><?php if ($event->visibility == FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_SECURE) { echo ' *'; } ?></h3>
    <div class="dates">
        <?php
        if ($event->hideendtime) {
            $add_end_time = false;
        } else {
            $add_end_time = true;
        }
        if ($event->allday) {
            echo fi_kilonkipinat_website::returnDateLabels($start_ts, $end_ts, false, false);
        } else {
            echo fi_kilonkipinat_website::returnDateLabels($start_ts, $end_ts, true, $add_end_time);
        }
        ?>
    </div>
</div>