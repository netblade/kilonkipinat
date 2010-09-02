<?php
$prefix = $data['prefix'];
$location = $data['object'];
$view = $data['view_location'];
?>
<div id="fi_kilonkipinat_events_location_location">
    <h3>Paikka: &(view['title']:h);</h3>
    
    <?php
    $location_object = $data['object'];
    if (class_exists('org_routamc_positioning_object'))
    {
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
                        Osoite: <span class="location">&(view['location']:h);</span>
                    </div>
                <?php 
            }
            $map = new org_routamc_positioning_map('fi_kilonkipinat_events_event_map');
            $map->zoom_level = $location_object->locationzoom;
            $marker = array('path' => '/style/img/pin-kkp.png');
            $map->add_object($location_object, $marker);
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
