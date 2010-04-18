<?php
$prefix = $data['prefix'];
?>
<div id="fi_kilonkipinat_accountregistration_wrapper">
    <h1>Rekisteröitymiset</h1>
<?php
if (count($data['pending'])>0) {
    echo "<table cellpadding=\"2\" cellspacing=\"2\" border=\"0\">\n";
    echo "\t<tr>\n";
    echo "\t\t<th>Nimi</th>\n";
    echo "\t\t<th>Sähköposti</th>\n";
    echo "\t\t<th>Sähköposti varmistettu</th>\n";
    echo "\t</tr>\n";
    foreach ($data['pending'] as $pending) {
        echo "\t<tr>\n";
        echo "\t\t<td><a href=\"" . $prefix . "manage_request/" . $pending->guid . "/\">" . $pending->firstname . "&nbsp;" . $pending->lastname . "</a></td>\n";
        echo "\t\t<td>" . $pending->email . "</td>\n";
        echo "\t\t<td>" . date('d.m.Y H:i', $pending->metadata->revised) . "</td>\n";
        echo "\t</tr>\n";
    }
    echo "</table>\n";
} else {
    echo "Ei rekisteröitymisiä.";
}

?>
</div>