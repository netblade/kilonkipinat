<?php
$prefix = $data['prefix'];
$location = $data['object'];
$view = $data['view_location'];
?>
<div id="fi_kilonkipinat_events_location_location">
    <h3>Paikka: &(view['title']:h);</h3>
    
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
    $object_position = new org_routamc_positioning_object($data['object']);
    $coordinates = $object_position->get_coordinates();
    if (   $coordinates['latitude']
        && $coordinates['longitude'])
    {
        $map = new org_routamc_positioning_map('fi_kilonkipinat_events_location_map');
        $map->zoom_level = $data['object']->locationzoom;
        $marker = array('path' => '/style/img/pin-kkp.png');
        $map->add_object($data['object'], $marker);
        $map->show(); 
    }
}
?>
<?php
if (strlen($view['content'])>5) {
?>
&(view['content']:h);
<?php
}
?>
<?php
    if(isset($data['datamanager']->types["downloads"]))
    {
        echo fi_kilonkipinat_website::getDownloads($data['datamanager']->types, 'downloads', 'Tiedostot');
    }
?>
</div>
