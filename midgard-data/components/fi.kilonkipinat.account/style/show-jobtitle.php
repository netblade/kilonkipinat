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