<?php
$prefix = $data['prefix'];

$person = $data['object'];
$view = $data['view_person'];
?>
<h1>&(person.firstname);&nbsp;&(person.lastname);</h1>
<div id="fi_kilonkipinat_account_person_activity">
<?php
if (   $data['items']
    && count($data['items']) > 0) {
?>
    <table cellpadding="2" cellspacing="2">
        <tr>
            <th>Milloin</th>
            <th>&nbsp;</th>
            <th>Mitä</th>
        </tr>
<?php
    foreach ($data['items'] as $item) {
        $published = "<abbr class=\"published\" title=\"" . strftime('%Y-%m-%dT%H:%M:%S%z', $item->metadata->published) . "\">" . date('d.m.Y H:i', $item->metadata->published) . "</abbr>";
        $summary = $item->summary;
        ?>
        <tr class="fi_kilonkipinat_account_person_activity_item">
            <td>&(published:h);</td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td><a href="/midcom-permalink-&(item.target);">&(summary:h);</a></td>
        </tr>
        <?php
    }
?>
    </table>
    <br /><br />
    <div id="org_maemo_brainstorm_latest_pager">
        <?php
        $data['qb']->show_pages();
        ?>
    </div>
<?php
} else {
?>
Ei aktiivisuutta
<?php
}
?>
</div>