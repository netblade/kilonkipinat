<?php
$prefix = $data['prefix'];

$event = $data['object'];
$view = $data['view_event'];
$start_ts = strtotime($event->start);
$end_ts = strtotime($event->end);
?>
<div id="fi_kilonkipinat_events_event">
    <h1>&(event.title:h);</h1>
    <div id="fi_kilonkipinat_events_event_details">
        <div class="dates">
            <h4>Ajankohta</h4>
            <abbr class="dtstart" title="<?php echo gmdate('Y-m-d\TH:i:s\Z', $start_ts); ?>"><?php echo fi_kilonkipinat_website::returnDateLabel('start', $start_ts, $end_ts); ?></abbr> -
            <abbr class="dtend" title="<?php echo gmdate('Y-m-d\TH:i:s\Z', $end_ts); ?>"><?php echo fi_kilonkipinat_website::returnDateLabel('end', $start_ts, $end_ts); ?></abbr>
        </div>
        <div class="event_content">
            <h4>Kuvaus</h4>
            &(event.content:h);
        </div>

        <?php
        if (   $_MIDGARD['user']
            && isset($event->contentpriv)
            && $event->contentpriv != '')
        {
        ?>
        <div class="event_content_private">
            <h4>Kuvaus (jäsenille)</h4>
            &(event.contentpriv:h);
        </div>
        <?php
        }
        ?>
        <?php
            if (isset($data['datamanager']->types["downloads"]))
            {
                echo fi_kilonkipinat_website::getDownloads($data['datamanager']->types, 'downloads', 'Tiedostot');
            }
        ?>
        <?php
            if (isset($data['datamanager']->types["esityslista"]))
            {
                echo fi_kilonkipinat_website::getDownloads($data['datamanager']->types, 'esityslista', 'Esityslistat');
            }
        ?>
        <?php
            if (   isset($data['datamanager']->types["poytakirja"])
                && $_MIDGARD['user'])
            {
                echo fi_kilonkipinat_website::getDownloads($data['datamanager']->types, 'poytakirja', 'Pöytäkirjat');
            }
        ?>
    </div>
<?php

$show_location = false;
$show_location_txt = false;

if ($_MIDGARD['user']) {
    $show_location = true;
} else {
    if ($event->locationvisibility == FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_PUBLIC) {
        $show_location = true;
    } elseif ($event->locationvisibility == FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_TEXT_PUBLIC) {
        $show_location_txt = true;
    }
}


if ($show_location) {
?>
    <div id="fi_kilonkipinat_events_event_location_details"><?php
    if ($event->eventslocation != 0) {
        $dl_path = $prefix . 'location/dl_view/'.$event->eventslocation;
        $_MIDCOM->dynamic_load($dl_path);
    } else {
?>
        <div id="fi_kilonkipinat_events_event_location">
<?php

if (   array_key_exists('location', $view)
    && trim(strip_tags($view['location'])) != '')
{ 
    ?>
        <div class="loc">
            Osoite: <span class="location">&(view['location']:h);</span>
        </div>
    <?php 
}
if (class_exists('org_routamc_positioning_object'))
{
    $object_position = new org_routamc_positioning_object($data['event']);
    $coordinates = $object_position->get_coordinates();
    if (   $coordinates['latitude']
        && $coordinates['longitude'])
    {
        $map = new org_routamc_positioning_map('fi_kilonkipinat_events_event_map');
        $map->zoom_level = $event->locationzoom;
        $marker = array('path' => '/style/img/pin-kkp.png');
        $map->add_object($event, $marker);
        $map->show(); 
    }
}
?>
        </div>
<?php
    }
?>
    </div>
<?php
} elseif ($show_location_txt) {
?>
    <div id="fi_kilonkipinat_events_event_location">
        Paikka: &(event.locationtext:h);
    </div>
<?php
}
?>
</div>