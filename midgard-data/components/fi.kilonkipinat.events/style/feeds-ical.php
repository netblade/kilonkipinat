<?php
$prefix = $data['prefix'];
echo "BEGIN:VCALENDAR\n";
echo "VERSION:2.0\n";
echo "PRODID:-//hacksw/handcal//NONSGML v1.0//EN\n";

// Add each event now.
if ($data['events'])
{
    foreach ($data['events'] as $event)
    {
        echo "BEGIN:VEVENT\n";
        echo "X-WR-TIMEZONE:Europe/Helsinki\n";
        echo "CREATED:" . date('Ymd\THis\Z', $event->metadata->created) . "\n";
        echo "DTSTAMP:" . date('Ymd\THis\Z', $event->metadata->revised) . "\n";
        echo "LAST-MODIFIED:" . date('Ymd\THis\Z', $event->metadata->revised) . "\n";
        if ($event->allday) {
            echo "DTSTART;VALUE=DATE:" . date('Ymd', strtotime($event->start)) . "\n";
            echo "DTEND;VALUE=DATE:" . date('Ymd', (strtotime($event->end)+(24*3600))) . "\n";
        } else {
            echo "DTSTART;TZID=Europe/Helsinki:" . date('Ymd\THis', strtotime($event->start)) . "\n";
            echo "DTEND;TZID=Europe/Helsinki:" . date('Ymd\THis', strtotime($event->end)) . "\n";
        }
        echo "SUMMARY:" . $event->title . "\n";
        echo "DESCRIPTION:" . strip_tags($event->content) . "\n";
        echo "URL:" . $_MIDCOM->permalinks->create_permalink($event->guid) . "\n";
        $location = '';
        if ($event->eventslocation != 0) {
            $eventlocation = new fi_kilonkipinat_events_location_dba($event->eventslocation);
            $location = $eventlocation->title;
        } else {
            if ($event->locationvisibility == FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_PUBLIC) {
                $location_object = $event;
                if (class_exists('org_routamc_positioning_object'))
                {
                    $object_position = new org_routamc_positioning_object($location_object);
                    $coordinates = $object_position->get_coordinates();
                    if (   $coordinates['latitude']
                        && $coordinates['longitude'])
                    {
                        $data['datamanager']->autoset_storage($event);
                        $view_event = $data['datamanager']->get_content_html();
                        if (trim(strip_tags($view_event['location'])) != '') {
                            $location = trim(strip_tags($view_event['location']));
                        }
                    }
                }
            }
            if (   $location == ''
                && (   $event->locationvisibility == FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_PUBLIC
                    || $event->locationvisibility == FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_TEXT_PUBLIC)) {
                $location = $event->locationtext;
            }
        }
        if ($location != '') {
            echo "LOCATION:" . $location . "\n";
        }
        echo "END:VEVENT\n";
    }
}
echo "END:VCALENDAR\n";
?>