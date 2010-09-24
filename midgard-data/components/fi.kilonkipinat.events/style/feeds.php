<?php
$prefix = $data['prefix'];
?>
Saatavilla olevat syötteet
<ul>
    <li><strong>RSS</strong>
        <ul>
            <li><a href="<?php echo $prefix . 'rss.xml'; ?>">Tulevat tapahtumat ja kokoukset</a></li>
			<?php
			if ($_MIDGARD['user']) {
			?>
            <li><a href="<?php echo $prefix . 'user/rss.xml'; ?>">Tulevat tapahtumat ja kokoukset (myös salaiset)</a></li>
			<?php
			}
			?>
        </ul>
    </li>
    <li><strong>iCal</strong>
        <ul>
            <li><a href="<?php echo $prefix . 'ical.ics'; ?>">Tulevat tapahtumat ja kokoukset</a></li>
            <li><a href="<?php echo $prefix . 'trips/ical.ics'; ?>">Tulevat tapahtumat</a></li>
            <li><a href="<?php echo $prefix . 'meetings/ical.ics'; ?>">Tulevat kokoukset</a></li>
			<?php
			if ($_MIDGARD['user']) {
			?>
            <li><a href="<?php echo $prefix . 'user/ical.ics'; ?>">Tulevat tapahtumat ja kokoukset (myös salaiset)</a></li>
            <li><a href="<?php echo $prefix . 'user/trips/ical.ics'; ?>">Tulevat tapahtumat (myös salaiset)</a></li>
            <li><a href="<?php echo $prefix . 'user/meetings/ical.ics'; ?>">Tulevat kokoukset (myös salaiset)</a></li>
			<?php
			}
			?>
        </ul>
    </li>
</ul>
<?php
if ($_MIDGARD['user']) {
?>
<p>Syötteiden, joissa on lisämerkintä "Myös salaiset", lukemiseen vaaditaan basic-auth kirjautumista tukeva ohjelma.</p>
<?php
}
?>