<?php
$prefix = $data['prefix'];

$jobtitle = $data['object'];
$view = $data['view_jobtitle'];
?>
<h1>Pestinimike: &(jobtitle.title);</h1>

Lyhennys: <?php echo $jobtitle->shorttitle ;?>
<br />
<?php
if ($jobtitle->jobgroup != 0) {
	$jobgroup = new fi_kilonkipinat_account_jobhistory_jobgroup_dba($jobtitle->jobgroup);
	if ($jobgroup) {
		echo "Ryhmä: <a href=\"" . $prefix . "jobhistory/jobgroup/view/" . $jobgroup->guid . "/\">" . $jobgroup->title . "</a>";
	}
}

?>

<h2>Pestit</h2>
<?php
$qb_jobs = fi_kilonkipinat_account_jobhistory_job_dba::new_query_builder();
$qb_jobs->add_constraint('jobtitle', '=', $jobtitle->id);
$qb_jobs->add_constraint('person', '<>', 0);
$qb_jobs->add_order('start', 'DESC');
$qb_jobs->add_order('person.lastname', 'ASC');
$qb_jobs->add_order('person.firstname', 'ASC');
$jobs = $qb_jobs->execute();

if (count($jobs)>0) {
    echo '<table cellpadding="2" cellspacing="2">'."\n";
}
foreach ($jobs as $job) {
    $person = new fi_kilonkipinat_account_person_dba($job->person);
    echo "\t<tr>\n";
    echo "\t\t<td><a href=\"" . $prefix . 'jobhistory/job/view/' . $job->guid . "/\">" . $person->firstname . ' ' . $person->lastname . "</td>\n";
    echo "\t\t<td>" . date('d.m.Y', strtotime($job->start)) . "</td>\n";
    echo "\t\t<td>-></td>\n";
    if (strtotime($job->start) < strtotime($job->end)) {
        echo "\t\t<td>" . date('d.m.Y', strtotime($job->end)) . "</td>\n";
    } else {
        echo "\t\t<td>&nbsp;</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n"
?>