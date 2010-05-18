<?php
$prefix = $data['prefix'];

$event = $data['trip'];

$start_ts = strtotime($data['trip']->start);
$end_ts = strtotime($data['trip']->end);
?>
<h3>&(event.title:h);</h3>
<div class="dates">
    <abbr class="dtstart" title="<?php echo gmdate('Y-m-d\TH:i:s\Z', $start_ts); ?>"><?php echo fi_kilonkipinat_website::returnDateLabel('start', $start_ts, $end_ts); ?></abbr> -
    <abbr class="dtend" title="<?php echo gmdate('Y-m-d\TH:i:s\Z', $end_ts); ?>"><?php echo fi_kilonkipinat_website::returnDateLabel('end', $start_ts, $end_ts); ?></abbr>
</div>