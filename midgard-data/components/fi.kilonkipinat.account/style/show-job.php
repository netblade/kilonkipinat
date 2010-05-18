<?php
$prefix = $data['prefix'];
$title = '';
$job = $data['object'];
$view = $data['view_job'];
if ($job->jobtitle != 0) {
	$jobtitle = new fi_kilonkipinat_account_jobhistory_jobtitle_dba($job->jobtitle);
	if ($jobtitle) {
		$title = '<a href="'.$prefix.'jobhistory/jobtitle/view/'.$jobtitle->guid.'/">' . $jobtitle->title . '</a>';
	}
}
if ($job->person != 0) {
	$person = new fi_kilonkipinat_account_person_dba($job->person);
	if ($person) {
	    if ($title != '') {
	        $title = '<a href="'.$prefix.'person/view/'.$person->guid.'/">' . $person->firstname . ' ' . $person->lastname . '</a>, ' . $title;
	    } else {
		    $title = '<a href="'.$prefix.'person/view/'.$person->guid.'/">' . $person->firstname . ' ' . $person->lastname . '</a>';
		}
	}
}
?>
<h1>Pesti: &(title:h);</h1>
<p>Alkoi: <?php echo date('d.m.Y', strtotime($job->start)); ?></p>
<?
if (strtotime($job->start) < strtotime($job->end)) {
?>
<p>Päättyi: <?php echo date('d.m.Y', strtotime($job->end)); ?></p>
<?php
}
?>
<p>Kuvaus:</p>
&(view['description']:h);