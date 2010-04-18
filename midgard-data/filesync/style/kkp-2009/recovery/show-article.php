<?php
// Available request keys: article, datamanager, edit_url, delete_url, create_urls
$view = $data['view_article'];

$_MIDCOM->load_library('org.openpsa.mail');
$status = '';
if (   isset($_POST)
    && isset($_POST['what'])) {
    $_MIDCOM->auth->request_sudo();
    if ($_POST['what'] == 'passwd') {
        if (isset($_POST['email'])) {
            $qb = midcom_db_person::new_query_builder();
            $qb->add_constraint('email', '=', trim($_POST['email']));
            $person = $qb->execute();

            if (   $person[0]
                && $person[0]->guid
                && $person[0]->email == trim($_POST['email'])) {

                // Generate a random password and activation Hash
                $password = '**';
                $length = 8;

                // Create a random password
                for ($i = 0; $i < $length ; $i++)
                {
                    $password .= chr(rand(97,122));
                }
                $person[0]->password = $password;
                $person[0]->update();

                $mail = new org_openpsa_mail();
                $mail->from = 'admin@kilonkipinat.fi';

                $mail->subject = '[KKp-web] Salasanan resetointi';
                $mail->body = "Hei\n\nUusi salasananne on " . str_replace('**', '', $password);
                $mail->to = $person[0]->email;
                $mail->send();
                $status = 'Uusi salasana lähetetty';
            } else {
                $status = 'Ei käyttäjää antamallanne salasanalla';
            }
        }
    } elseif ($_POST['what'] == 'account') {
        if (   $_POST['firstname'] != ''
            && $_POST['lastname'] != ''
            && $_POST['email'] != '')
        {
            $person = new midcom_db_person();
            
            $person->firstname = $_POST['firstname'];
            $person->lastname = $_POST['lastname'];
            $person->email = $_POST['email'];
            $username = strtolower($person->firstname . '.' . $person->lastname);
            $username = str_replace(' ', '', $username);
            $username = str_replace('ä', 'a', $username);
            $username = str_replace('ö', 'o', $username);
            $username = str_replace('Ä', 'a', $username);
            $username = str_replace('Ö', 'o', $username);
            $username = str_replace('Å', 'a', $username);
            $username = str_replace('å', 'a', $username);
            $person->username = $username;

            // Generate a random password and activation Hash
            $password = '**';
            $length = 8;

            // Create a random password
            for ($i = 0; $i < $length ; $i++)
            {
                $password .= chr(rand(97,122));
            }
            
            $person->password = $password;
            $person->create();

            $group = new midcom_db_group();
            $group->get_by_path('/kkp_admins/editoijat');

            $member = new midcom_db_member();
            $member->uid = $person->id;
            $member->gid = $group->id;
            $member->create();
            
            
            $mail = new org_openpsa_mail();
            $mail->from = 'admin@kilonkipinat.fi';

            $mail->subject = '[KKp-web] Tunnukset sivustolle';
            $mail->body = "Hei\n\nTunnus: " . $username;
            $mail->body .= "\nSalasana: " . str_replace('**', '', $password);
            $mail->to = $person->email;
            $mail->send();
            $status = 'Tunnukset lähetetty.';

        }
    }
    $_MIDCOM->auth->drop_sudo();
}

?>

<h1>&(view['title']:h);</h1>

&(view['content']:h);

<p>&(status:h);</p>

<h2><a href="#" onclick="jQuery('#passwd_container').toggle('slow')">Salasanan resetointi</a></h2>
<div id="passwd_container" style="display: none;">
<form method="post">
    <p>Saat uuden salasanan, kun annan sähköpostiosoitteesi.</p>
    <input type="hidden" name="what" value="passwd" />
    <label for="email">Sähköpostiosoitteesi</label><br />
    <input type="text" id="email" name="email" /><br />
    <br />
    <input type="submit" value="Resetoi" />
</form>
</div>

<h2><a href="#" onclick="jQuery('#registry_container').toggle('slow')">Uusi tunnus</a></h2>
<div id="registry_container" style="display: none;">
<p>Ota yhteyttä Oskuun.</p>
</div>
<?php
/*
<h2><a href="#" onclick="jQuery('#registry_container').toggle('slow')">Uusi tunnus</a></h2>
<div id="registry_container" style="display: none;">
<form method="post">
    <p>Tunnuksen sivustolle saat antamalla perustiedot itsestäsi.</p>
    <input type="hidden" name="what" value="account" />
    <label for="firstname">Etunimi</label><br />
    <input type="text" id="email" name="firstname" /><br />
    <label for="firstname">Sukunimi</label><br />
    <input type="text" id="email" name="lastname" /><br />
    <label for="email">Sähköpostiosoite</label><br />
    <input type="text" id="email" name="email" /><br />
    <br />
    <input type="submit" value="Luo tunnus" />
</form>
</div>
*/
?>