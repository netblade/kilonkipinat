<?php
$prefix = $data['prefix'];
$locations = $data['locations'];
?>
<h1>Tapahtumien paikkatiedot</h1>
<div id="fi_kilonkipinat_events_locations">
    <table class="tablesorter">
		<thead>
	        <tr>
	            <th>Nimi</th>
	            <th>Osoite</th>
	        </tr>
		</thead>
		<tbody>
<?php
foreach ($locations as $location) {
    if (! $data['datamanager']->autoset_storage($location))
    {
        debug_push_class(__CLASS__, __FUNCTION__);
        debug_add("The datamanager for location {$location->id} could not be initialized, skipping it.");
        debug_print_r('Object was:', $trip);
        debug_pop();
        continue;
    }
    $view_location = $data['datamanager']->get_content_html();
?>
            <tr>
                <td><a href="<?php echo $prefix .'location/view/'.$location->guid; ?>"><?php echo $location->title; ?></a></td>
                <td><span class="location">&(view_location['location']:h);</span></td>
            </tr>
<?php
}
?>	    </tbody>
    </table>
</div>