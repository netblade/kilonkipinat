<h1>Käyttäjät</h1>
<div id="fi_kilonkipinat_account_index_persons">
    <table>
        <tr>
            <th>Nimi</th>
            <th>Kutsumanimi</th>
            <th>Puhelin</th>
            <th>Viimesin loggautuminen</th>
            <th>GTalk</th>
            <th>MSN</th>
            <th>Skype</th>
            <th>ICQ</th>
            <th>IRC</th>
            <th>Facebook</th>
        </tr>
        <tr>
            <td colspan="10" class="fat_line">&nbsp;</td>
        </tr>
<?php
foreach ($data['persons'] as $person) {
    $nickname = $person->nickname;
    if ($nickname == '') {
        $nickname = $person->firstname;
    }
    $last_login = $person->get_parameter('midcom', 'last_login');
    if ($last_login != '') {
        $last_login = date('d.m.Y H:i', $last_login);
    } else {
        $last_login = '&nbsp;';
    }
?>
        <tr>
            <td><a href="<?php echo $data['prefix'] . 'person/view/' . $person->guid . '/'; ?>">&(person.firstname:h);&nbsp;&(person.lastname:h);</a></td>
            <td>&(nickname:h);</td>
            <td>&(person.handphone:h);</td>
            <td>&(last_login:h);</td>
            <td align="center"><?php if ($person->imJabber != '') { echo '<img src="/midcom-static/fi.kilonkipinat.website/misc/gtalk.png" border="0" alt="' . $person->imJabber . '" title="' . $person->imJabber . '" />'; } else { echo "&nbsp;"; } ?></td>
            <td align="center"><?php if ($person->imMsn != '') { echo '<img src="/midcom-static/fi.kilonkipinat.website/misc/indication_msn.gif" border="0" alt="' . $person->imMsn . '" title="' . $person->imMsn . '" />'; } else { echo "&nbsp;"; } ?></td>
            <td align="center"><?php if ($person->imSkype != '') { echo '<img src="/midcom-static/fi.kilonkipinat.website/misc/skype.png" border="0" alt="' . $person->imSkype . '" title="' . $person->imSkype . '" />'; } else { echo "&nbsp;"; } ?></td>
            <td align="center"><?php if ($person->imIcq != '') { echo '<img src="/midcom-static/fi.kilonkipinat.website/misc/indication_icq.gif" border="0" alt="' . $person->imIcq . '" title="' . $person->imIcq . '" />'; } else { echo "&nbsp;"; } ?></td>
            <td align="center"><?php if ($person->imIrcGalleria != '') { echo '<a target="_blank" href="http://irc-galleria.net/user/'.$person->imIrcGalleria.'"><img src="/midcom-static/fi.kilonkipinat.website/misc/indication_irc.gif" border="0" alt="' . $person->imIrcGalleria . '" /></a>'; } else { echo "&nbsp;"; } ?></td>
            <td align="center"><?php if ($person->imFacebook != '') { echo '<a target="_blank" href="'.$person->imFacebook.'"><img src="/midcom-static/fi.kilonkipinat.website/misc/facebook.png" border="0" alt="' . $person->imFacebook . '" /></a>'; } else { echo "&nbsp;"; } ?></td>
        </tr>
        <tr>
            <td colspan="10" class="line">&nbsp;</td>
        </tr>
<?php
}
?>
    </table>
<?php
if (   isset($data['requests'])
    && $data['requests'] != '') {
    echo "<br /><br />" . $data['requests'];
}

?>
</div>