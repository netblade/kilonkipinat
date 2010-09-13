<?php
$prefix = $data['prefix'];

$event = $data['object'];
$view = $data['view_event'];
$start_ts = strtotime($event->start);
$end_ts = strtotime($event->end);
?>
<div id="fi_kilonkipinat_events_event">
    <h1>&(event.title:h);<?php if ($event->visibility == FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_SECURE) { echo ' *'; } ?></h1>
    <div id="fi_kilonkipinat_events_event_details">
        <div class="dates">
            <h4>Ajankohta</h4>
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
        <div class="event_content">
            <h4>Kuvaus</h4>
            &(event.content:h);
        </div>

        <?php
        if (   $_MIDGARD['user']
            && isset($event->contentprivate)
            && $event->contentprivate != '')
        {
        ?>
        <div class="event_content_private">
            <h4>Kuvaus (jäsenille)</h4>
            &(event.contentprivate:h);
        </div>
        <?php
        }
        ?>
        <?php
        if (strlen($event->url) > 5 ) {
            echo "<p><a href=\"".$event->url."\" target=\"_blank\">Lisätiedot</a></p>";
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
    if ($event->locationvisibility == FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_TEXT_PUBLIC) {
        $show_location_txt = true;
    }
} else {
    if ($event->locationvisibility == FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_PUBLIC) {
        $show_location = true;
    } elseif ($event->locationvisibility == FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_TEXT_PUBLIC) {
        $show_location_txt = true;
    }
}


if ($show_location) {
    $show_location_txt = true;
?>
    <div id="fi_kilonkipinat_events_event_location_details"><?php
    if ($event->eventslocation != 0) {
        $dl_path = $prefix . 'location/dl_view/'.$event->eventslocation;
        $_MIDCOM->dynamic_load($dl_path);
    } else {
        $location_object = $data['object'];
        if (class_exists('org_routamc_positioning_object'))
        {
?>
        <div id="fi_kilonkipinat_events_event_location">
<?php
    $object_position = new org_routamc_positioning_object($location_object);
    $coordinates = $object_position->get_coordinates();
    if (   $coordinates['latitude']
        && $coordinates['longitude'])
    {
        if (   array_key_exists('location', $view)
            && trim(strip_tags($view['location'])) != '')
        { 
            ?>
                <div class="loc">
                    <h3>Paikka:</h3>
                    <span class="location">&(view['location']:h);</span>
                </div>
            <?php 
        }
        $map = new org_routamc_positioning_map('fi_kilonkipinat_events_event_map');
        $map->zoom_level = $location_object->locationzoom;
        $marker = array('path' => '/style/img/pin-kkp.png');
        $map->add_object($location_object, $marker);
        $map->show(); 
    } elseif ($show_location_txt) {
    ?>
        <div id="fi_kilonkipinat_events_event_location">
            <h3>Paikka: &(event.locationtext:h);</h3>
        </div>
    <?php
    }
?>
        </div>
<?php
        } elseif ($show_location_txt) {
        ?>
            <div id="fi_kilonkipinat_events_event_location">
                <h3>Paikka: &(event.locationtext:h);</h3>
            </div>
        <?php
        }
    }
?>
    </div>
<?php
} elseif ($show_location_txt) {
?>
    <div id="fi_kilonkipinat_events_event_location">
        <h3>Paikka: Paikka: &(event.locationtext:h);</h3>
    </div>
<?php
}
?>
<?php
$comments_node = fi_kilonkipinat_website::seek_comments($data);
if ($comments_node)
{
    $comments_url = $comments_node[MIDCOM_NAV_RELATIVEURL] . "comment/{$event->guid}";
}
?>
<div id="fi_kilonkipinat_events_event_comments">
<?php
if (isset($comments_url))
{
    $_MIDCOM->dynamic_load($comments_url);
}
?>
</div>
</div>