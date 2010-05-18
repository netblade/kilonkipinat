<?php
$prefix = $data['prefix'];

$jobgroup = $data['object'];
$view = $data['view_jobgroup'];
?>
<h1>Pestiryhmä: &(jobgroup.title);</h1>

<?php
$qb_titles = fi_kilonkipinat_account_jobhistory_jobtitle_dba::new_query_builder();
$qb_titles->add_constraint('jobgroup', '=', $jobgroup->id);
$qb_titles->add_order('metadata.score');
$titles = $qb_titles->execute();
if (   $titles
    && count($titles) > 0) {
	echo "<h2>Pestinimikkeet</h2>";
    echo "<ul>\n";
    foreach ($titles as $title) {
        $jobtitles[$title->id] = $title->id;
        echo "<li>";
        echo "<div class=\"fi_kilonkipinat_account_jobhistory_management_tools\">\n";
        echo "<a title=\"Muokkaa\" href=\"" . $prefix . "jobhistory/jobtitle/edit/" . $title->guid . "/\"><img src=\"/midcom-static/fi.kilonkipinat.website/fam/page_edit.png\" /></a>";
        echo "<a title=\"Poista\" href=\"" . $prefix . "jobhistory/jobtitle/delete/" . $title->guid . "/\"><img src=\"/midcom-static/fi.kilonkipinat.website/fam/page_delete.png\" /></a>";
        echo "</div>\n";
        echo "<a href=\"" . $prefix . "jobhistory/jobtitle/view/" . $title->guid . "/\">" . $title->title . "</li>";
    }
    echo "</ul>\n";
}
unset($qb_titles);
unset($titles);
?>
