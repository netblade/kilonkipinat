<?php
$emailmapping = $data['object'];
$view = $data['view_emailmapping'];
$persons = fi_kilonkipinat_emailmappings_viewer::loadPersons($emailmapping->persons);

$persons_str = '';
foreach ($persons as $person) {
    if ($persons_str != '') {
        $persons_str .= ', ';
    }

    $persons_str .=  $person->firstname . ' ' . $person->lastname;
}
?>
<h1>&(emailmapping.name); -> &(persons_str);</h1>
