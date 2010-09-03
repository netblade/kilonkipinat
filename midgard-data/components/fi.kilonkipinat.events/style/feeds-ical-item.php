
BEGIN:VEVENT
DTSTAMP:<?php echo date('Ymd\THIM\Z', strtotime($data['event']->metadata_revised));?> 
DTSTART:<?php echo date('Ymd\THIM\Z', strtotime($data['event']->start));?> 
DTEND:<?php echo date('Ymd\THIM\Z', strtotime($data['event']->end));?> 
SUMMARY:<?php echo $data['event']->title; ?> 
DESCRIPTION:<?php echo $data['event']->content; ?> 
END:VEVENT 
