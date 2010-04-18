<?php
$prefix = $data['prefix'];
$request = $data['request'];
$email_confirmed = date('d.m.Y H:i', $request->metadata->revised);

function list_groups($parent)
{
    $str = '';
    $qb_groups = midcom_db_group::new_query_builder();
    $qb_groups->add_constraint('owner', '=', $parent);
    $groups = $qb_groups->execute();
    if (count($groups)>0) {
        $str =  "<ul>\n";
        foreach ($groups as $group) {
            $str .= "<li>";
            $str .= '<input name="add_to_groups['.$group->guid.']" id="group_' . $group->guid . '" type="checkbox" value="' . $group->guid . '">&nbsp;<label for="group_' . $group->guid . '">'.$group->official.'</label>';
            $str .= "</li>\n";
            
        }
        $str .= list_groups($group->id);
        $str .= "</ul>";
    }
    return $str;
}


?>
<div id="fi_kilonkipinat_accountregistration_wrapper">
    <h1>Hallinnoi</h1>
    <?php
    if (isset($data['message'])) {
        $message = $data['message'];
    ?>
    <div id="fi_kilonkipinat_accountregistration_messages_wrapper">
        <div id="fi_kilonkipinat_accountregistration_messages_container" class="corners15">
            <h2>&(message['title']:h);</h2>
            <p>&(message['content']:h);</p>
        </div>
    </div>
    <?php
    }

    ?>
    <h2>Rekisteröitymisen tiedot</h2>
    <table cellpadding="3" cellspacing="0" border="0">
        <tr>
            <th>Etunimi</th>
            <td>&(request.firstname);</td>
        </tr>
        <tr>
            <th>Sukunimi</th>
            <td>&(request.lastname);</td>
        </tr>
        <tr>
            <th>Sähköposti</th>
            <td>&(request.email);</td>
        </tr>
        <tr>
            <th>Sähköposti varmistettu</th>
            <td>&(email_confirmed:h);</td>
        </tr>
    </table>
    <form method="POST">
        <br /><br />
        <h2>Tunnuksen luominen</h2>
        <div id="fi_kilonkipinat_accountregistration_fields">
            <?php
            $username = '';
            switch ($data['config']->get('username_generation')) {
                default:
                case 'firstname.lastname':
                    $username = fi_kilonkipinat_accountregistration_viewer::cleanUserNameStr($request->firstname);
                    $username .= '.';
                    $username .= fi_kilonkipinat_accountregistration_viewer::cleanUserNameStr($request->lastname);
                    break;
                case 'firstname_lastname':
                    $username = fi_kilonkipinat_accountregistration_viewer::cleanUserNameStr($request->firstname);
                    $username .= '_';
                    $username .= fi_kilonkipinat_accountregistration_viewer::cleanUserNameStr($request->lastname);
                    break;
                case 'email':
                    $username = fi_kilonkipinat_accountregistration_viewer::cleanUserNameStr($email);
                    break;
            }
            
            ?>
            <div id="fi_kilonkipinat_accountregistration_search_user_results"></div>
            <table>
                <tr>
                    <th>Käyttäjätunnus</th>
                    <td><input type="text" name="username" value="&(username);" id="fi_kilonkipinat_accountregistration_username" /></td>
                </tr>
                <tr>
                    <th>Liitä tunnukseen</th>
                    <td>
                        <input type="hidden" name="merge_user_guid" id="fi_kilonkipinat_accountregistration_merge_user_guid" />
                        <input type="text" name="search_user" id="fi_kilonkipinat_accountregistration_search_user_text" />&nbsp;<a href="#" onclick="searchUser(); return false;">Hae</a>
                    </td>
                </tr>
            </table>
        </div>
        <br /><br />
        <div id="fi_kilonkipinat_accountregistration_groups">
            <h2>Henkilön ryhmät</h2>
            <?php echo list_groups(0); ?>
        </div>
        <div id="fi_kilonkipinat_accountregistration_submit">
            <input type="submit" value="Luo tunnus ja lähetä tiedot sähköpostilla" />
        </div>
    </form>
</div>
<script>
function searchUser()
{
    searchStr = jQuery('#fi_kilonkipinat_accountregistration_search_user_text').val();
    jQuery('#fi_kilonkipinat_accountregistration_search_user_results').load('/midcom-exec-fi.kilonkipinat.accountregistration/search_user.php?search_str='+searchStr);
    
}

function chooseUser(userguid, username)
{
    jQuery('#fi_kilonkipinat_accountregistration_merge_search_results td').removeClass('selected');
    jQuery('#user_'+userguid+' td').addClass('selected');
    jQuery('#fi_kilonkipinat_accountregistration_merge_user_guid').val(userguid);
    if (username != '') {
        jQuery('#fi_kilonkipinat_accountregistration_username').val(username);
    }
}
</script>