<?php
$prefix = $data['prefix'];

$person = $data['object'];
$view = $data['view_person'];
?>
<h1>&(person.firstname);&nbsp;&(person.lastname);</h1>
<table>
<?php

foreach ($data['schemadb_person']['default']->fields as $key => $data) {
    $content = '';
    if (   is_array($data['storage'])) {
        if (   isset($data['storage']['location'])
            && $data['storage']['location'] != 'parameter') {
            $content = $person->$data['storage']['location'];
        } else {
            $content = $person->get_parameter('midcom.helper.datamanager2', $data['storage']['name']);
        }
    } elseif ($data['storage'] == 'parameter') {
        $content = $person->get_parameter('midcom.helper.datamanager2', $key);
    } else {
        $content = $person->$data['storage'];
    }
    if ($data['type'] == 'date') {
        if (   isset($data['widget_config'])
            && isset($data['widget_config']['show_time'])
            && $data['widget_config']['show_time'] == false) {
            $content = date('d.m.Y', strtotime($content));
        } else {
            $content = date('d.m.Y H:i', strtotime($content));
        }
        
    }
?>
    <tr>
        <th>&(data['title']:h);</th>
        <td>&(content:h);</td>
    </tr>
<?php
}
?>
</table>

<h2>Pestit</h2>
<?php
$qb_jobs = fi_kilonkipinat_account_jobhistory_job_dba::new_query_builder();
$qb_jobs->add_constraint('person', '=', $person->id);
$qb_jobs->add_constraint('jobtitle', '<>', 0);
$qb_jobs->add_order('start', 'DESC');
$qb_jobs->add_order('jobtitle.title', 'ASC');
$jobs = $qb_jobs->execute();

if (count($jobs)>0) {
    echo '<table cellpadding="2" cellspacing="2">'."\n";
}
foreach ($jobs as $job) {
    $jobtitle = new fi_kilonkipinat_account_jobhistory_jobtitle_dba($job->jobtitle);
    echo "\t<tr>\n";
    echo "\t\t<td><a href=\"" . $prefix . 'jobhistory/job/view/' . $job->guid . "/\">" . $jobtitle->title . "</td>\n";
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