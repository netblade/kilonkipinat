<?php
$prefix = $data['prefix'];

$event = $data['object'];

$start_ts = strtotime($event->start);
$end_ts = strtotime($event->end);
?>
<h1>&(event.title:h);</h1>
<div class="dates">
    <abbr class="dtstart" title="<?php echo gmdate('Y-m-d\TH:i:s\Z', $start_ts); ?>"><?php echo fi_kilonkipinat_website::returnDateLabel('start', $start_ts, $end_ts); ?></abbr> -
    <abbr class="dtend" title="<?php echo gmdate('Y-m-d\TH:i:s\Z', $end_ts); ?>"><?php echo fi_kilonkipinat_website::returnDateLabel('end', $start_ts, $end_ts); ?></abbr>
</div>
<div class="event_content">
    <h4>Tapahtuman kuvaus</h4>
    &(event.content:h);
</div>

<?php
if (   $_MIDGARD['user']
    && isset($event->contentpriv)
    && $event->contentpriv != '')
{
?>
<div class="event_content_private">
    <h4>Tapahtuman kuvaus (jäsenille)</h4>
    &(event.contentpriv:h);
</div>
<?php
}
?>