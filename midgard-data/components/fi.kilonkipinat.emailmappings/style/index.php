<?php
$prefix = $data['prefix'];

?>
<div id="fi_kilonkipinat_emailmapper_index">
<h1><?php echo $data['topic']->extra; ?></h1>

<p>Viimeisin automaattinen luku <?php echo fi_kilonkipinat_website::returnDate($data['last_change'], 'medium'); ?></p>
<p>Viimeisimmät muutokset päivitetty <?php echo fi_kilonkipinat_website::returnDate($data['last_update'], 'medium'); ?></p>

<h2><a href="#" onclick="jQuery('#fi_kilonkipinat_emailmapper_index_automatic_wrapper').toggle('slow'); return false;">Automaattisesti generoidut (<?php echo count($data['automatic_mappings']); ?>)</a></h2>
<div id="fi_kilonkipinat_emailmapper_index_automatic_wrapper" style="display: none;">
    <table class="tablesorter">
		<thead>
        	<tr>
            	<th>Mikä</th>
            	<th>Minne</th>
        	</tr>
		</thead>
		<tbody>
<?php
    foreach ($data['automatic_mappings'] as $mapping) {
        echo "\t<tr>\n";
        echo "\t\t<td>" . $mapping['name'] . "</td>\n";
        echo "\t\t<td>" . $mapping['email'] . "</td>\n";
        echo "\t</tr>\n";
    }
?>
		</tbody>
    </table>
</div>

<h2><a href="#" onclick="jQuery('#fi_kilonkipinat_emailmapper_index_additional_wrapper').toggle('slow'); return false;">Lisäohjaukset (<?php echo count($data['additional_mappings']); ?>)</a></h2>
<div id="fi_kilonkipinat_emailmapper_index_additional_wrapper" style="display: none;">
    <table class="tablesorter">
		<thead>
	        <tr>
	            <th>Mikä</th>
	            <th>Minne</th>
	            <th>Keille</th>
	            <th class="{sorter: 'fiDate'}">Muokattu</th>
	            <th class="{sorter: false}">Työkalut</th>
	        </tr>
		</thead>
		<tbody>
<?php
    $mapping_names = array();
    foreach ($data['additional_mappings'] as $mapping) {
	    $qb_mapping = fi_kilonkipinat_emailmappings_emailmapping_dba::new_query_builder();
        $qb_mapping->add_constraint('name', '=', trim($mapping['name']));
        $qb_mapping->set_limit(1);
        $mappings = $qb_mapping->execute();
       	echo "\t<tr>\n";
       	echo "\t\t<td>" . $mapping['name'] . "</td>\n";
       	echo "\t\t<td>" . $mapping['emails'] . "</td>\n";
        if (   is_array($mappings)
			&& count($mappings) > 0) {
            $emailmapping = $mappings[0];
            $mapping_names[] = trim($mapping['name']);

            $persons = fi_kilonkipinat_emailmappings_viewer::loadPersons($emailmapping->persons);

            $persons_str = '';
            foreach ($persons as $person) {
                if ($persons_str != '') {
                    $persons_str .= ', ';
                }

                $persons_str .=  $person->firstname . ' ' . $person->lastname;
            }
            echo "\t\t<td>";
            echo $persons_str;
            echo "</td>\n";
            
            echo "\t\t<td>";
            echo fi_kilonkipinat_website::returnDate($emailmapping->metadata->revised, 'medium');
            echo "</td>\n";
            echo "\t\t<td>";
            echo "&nbsp;&nbsp;&nbsp;";
            if ($emailmapping->can_do('midgard:update')) {
                echo "<a title=\"Muokkaa\" href=\"" . $prefix . 'emailmapping/edit/' . $mappings[0]->guid . "/\"><img src=\"/midcom-static/fi.kilonkipinat.emailmappings/email_edit.png\" /></a>";
            }
            echo "&nbsp;&nbsp;&nbsp;";
            if ($emailmapping->can_do('midgard:delete')) {
                echo "<a title=\"Poista\" href=\"" . $prefix . 'emailmapping/delete/' . $mappings[0]->guid . "/\"><img src=\"/midcom-static/fi.kilonkipinat.emailmappings/email_delete.png\" /></a>";
            }
            echo "&nbsp;&nbsp;&nbsp;";
            echo "</td>\n";
        } else {
			echo "\t\t<td>&nbsp;</td>\n";
			echo "\t\t<td>&nbsp;</td>\n";
			echo "\t\t<td>&nbsp;</td>\n";
		}
        echo "\t</tr>\n";
    }
?>
		<tbody>
    </table>
<?php
$qb = fi_kilonkipinat_emailmappings_emailmapping_dba::new_query_builder();
if (count($mapping_names)>0) {
	$qb->add_constraint('name', 'NOT IN', $mapping_names);
}
$results = $qb->execute();

if (count($results) != 0) {
?>
<br /><br /><br />
<h3>Odottaa päivitystä</h3>
<table class="tablesorter">
	<thead>
	    <tr>
	        <th>Mikä</th>
	        <th>Keille</th>
	        <th class="{sorter: 'fiDate'}">Muokattu</th>
	        <th class="{sorter: false}">Työkalut</th>
	    </tr>
	</thead>
	<tbody>
<?php
    foreach ($results as $result) {

        $persons = fi_kilonkipinat_emailmappings_viewer::loadPersons($result->persons);

        $persons_str = '';
        foreach ($persons as $person) {
            if ($persons_str != '') {
                $persons_str .= ', ';
            }

            $persons_str .=  $person->firstname . ' ' . $person->lastname;
        }
        echo "\t<tr>\n";
        echo "\t\t<td>" . $result->name . "</td>\n";
        echo "\t\t<td>" . $persons_str . "</td>\n";
        echo "\t\t<td>";
        echo fi_kilonkipinat_website::returnDate($result->metadata->revised, 'medium');
        echo "</td>\n";
        echo "\t\t<td>";
        echo "&nbsp;&nbsp;&nbsp;";
        if ($result->can_do('midgard:update')) {
            echo "<a title=\"Muokkaa\" href=\"" . $prefix . 'emailmapping/edit/' . $result->guid . "/\"><img src=\"/midcom-static/fi.kilonkipinat.emailmappings/email_edit.png\" /></a>";
        }
        echo "&nbsp;&nbsp;&nbsp;";
        if ($result->can_do('midgard:delete')) {
            echo "<a title=\"Poista\" href=\"" . $prefix . 'emailmapping/delete/' . $result->guid . "/\"><img src=\"/midcom-static/fi.kilonkipinat.emailmappings/email_delete.png\" /></a>";
        }
        echo "&nbsp;&nbsp;&nbsp;";
        echo "</td>\n";
        echo "\t</tr>\n";
    }
?>
		<tbody>
    </table>
<?php
}

?>
</div>

</div>