<?php
$prefix = $data['prefix'];
?>
<h1>Hallinnoi pestejä</h1>
<?php
$qb_groups = fi_kilonkipinat_account_jobhistory_jobgroup_dba::new_query_builder();
$qb_groups->add_order('metadata.score');
$groups = $qb_groups->execute();
$jobtitles = array();

if (   $groups
    && count($groups) > 0)
{
    echo "<div id=\"fi_kilonkipinat_account_jobhistory_management\">";
    echo "<ul>\n";
    foreach ($groups as $group) {
        echo "<li>";
        echo "<div class=\"fi_kilonkipinat_account_jobhistory_management_tools\">\n";
        echo "<a title=\"Muokkaa\" href=\"" . $prefix . "jobhistory/jobgroup/edit/" . $group->guid . "/\"><img src=\"/midcom-static/fi.kilonkipinat.website/fam/page_edit.png\" /></a>";
        echo "<a title=\"Poista\" href=\"" . $prefix . "jobhistory/jobgroup/delete/" . $group->guid . "/\"><img src=\"/midcom-static/fi.kilonkipinat.website/fam/page_delete.png\" /></a>";
        echo "</div>\n";
        echo "<a class=\"group\" href=\"" . $prefix . "jobhistory/jobgroup/view/" . $group->guid . "/\">" . $group->title . "</a>\n";
        
        $qb_titles = fi_kilonkipinat_account_jobhistory_jobtitle_dba::new_query_builder();
        $qb_titles->add_constraint('jobgroup', '=', $group->id);
        $qb_titles->add_order('metadata.score');
        $titles = $qb_titles->execute();
        if (   $titles
            && count($titles) > 0) {
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
        echo "</li>\n";
    }
    echo "<ul>\n";
    if (count($jobtitles) > 0) {
        $qb_titles = fi_kilonkipinat_account_jobhistory_jobtitle_dba::new_query_builder();
        $qb_titles->add_constraint('id', 'NOT IN', $jobtitles);
        $qb_titles->add_order('metadata.score');
        $titles = $qb_titles->execute();
        if (   $titles
            && count($titles) > 0) {
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
    }
    echo "</div>";
}

?>