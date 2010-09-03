<?php
$prefix = $data['prefix'];
?>
Saatavilla olevat syötteet
<ul>
    <li><strong>RSS</strong>
        <ul>
            <li><a href="<?php echo $prefix . 'rss.xml'; ?>">Tulevat tapahtumat ja kokoukset</a></li>
        </ul>
    </li>
    <li><strong>iCal</strong>
        <ul>
            <li><a href="<?php echo $prefix . 'ical.ics'; ?>">Tulevat tapahtumat ja kokoukset</a></li>
            <li><a href="<?php echo $prefix . 'trips/ical.ics'; ?>">Tulevat tapahtumat</a></li>
            <li><a href="<?php echo $prefix . 'meetings/ical.ics'; ?>">Tulevat kokoukset</a></li>
        </ul>
    </li>
</ul>