<?php
$prefix = $data['prefix'];
$url_prefix = $_MIDCOM->get_host_name() . $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX) . "view_event/";
echo "BEGIN:VCALENDAR\n";
echo "VERSION:2.0\n";
echo "PRODID:-//hacksw/handcal//NONSGML v1.0//EN\n";

// Add each event now.
if ($data['events'])
{
    foreach ($data['events'] as $event)
    {
		$content = $event->content;
		if (   strstr($data['handler_id'], 'user')
			&& strlen(strip_tags($event->contentprivate))>0) {
			$content .= '\n\nLisätiedot jäsenille:\n\n' . $event->contentprivate;
		}
		$content = str_replace('<p>', '\n\n', $content);
		$content = str_replace('<br />', '\n', $content);
		$content = str_replace('<li>', '\n', $content);
		$content = trim($content, '\n');
		$content = str_replace('\n\n\n', '\n\n', $content);
		$content = str_replace('\n\n\n', '\n\n', $content);
		$content = str_replace("\n", "\n  ", $content);
		$content = strip_tags($content);
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
        echo "DESCRIPTION:" . $content . "\n";
//        echo "URL:" . $_MIDCOM->permalinks->create_permalink($event->guid) . "\n";
		echo "URL:" . $url_prefix . $event->guid . '/';
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
                    $location_object = $object_position->seek_location_object();

                    if (   $location_object) {
                        if (   $location_object->street
                            && strlen($location_object->street)>0)
                        {
                            $location .= $location_object->street;
                        }
                        if (   $location_object->postalcode
                            && strlen($location_object->postalcode)>0)
                        {
                            if ($location != '') {
                                $location .= ', ' . $location_object->postalcode;
                            } else {
                                $location .= $location_object->postalcode;
                            }
                        }
                        if (   $location_object->region
                            && strlen($location_object->region)>0)
                        {
                            if ($location != '') {
                                $location .= ', ' . $location_object->region;
                            } else {
                                $location .= $location_object->region;
                            }
                        }
                        if ($event->locationtext != '') {
                            $location = $event->locationtext . ', ' . $location;
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