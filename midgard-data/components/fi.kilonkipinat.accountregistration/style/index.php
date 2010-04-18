<div id="fi_kilonkipinat_accountregistration_wrapper">
<h1>Salasanan resetointi / rekisteröinti</h1>
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
<p>Valitse alta, mitä haluat tehdä</p>
<?php
if ($data['config']->get('enable_password_reset'))
{
?>
<a href="#" onclick="jQuery('#fi_kilonkipinat_accountregistration_reset_password_wrapper').toggle('slow'); return false;"><h2>Salasanan resetointi</h2></a>
<div id="fi_kilonkipinat_accountregistration_reset_password_wrapper" style="display: none;">
    <div id="fi_kilonkipinat_accountregistration_reset_password_container" class="corners15">
        <form method="post">
            <input type="hidden" name="action_type" value="reset_password">
            <span class="input_container">
                <label for="username">Käyttäjätunnuksesi</label>
                <input type="text" id="username" name="username" />
            </span>
            <input type="submit" class="submit" value="Lähetä sähköposti" />
        </form>
    </div>
</div>
<?php
}

if ($data['config']->get('enable_account_creation'))
{
?>
<a href="#" onclick="jQuery('#fi_kilonkipinat_accountregistration_registration_wrapper').toggle('slow'); return false;"><h2>Rekisteröinti</h2></a>
<div id="fi_kilonkipinat_accountregistration_registration_wrapper" style="display: none;">
    <div id="fi_kilonkipinat_accountregistration_registration_container" class="corners15">
        <form method="post">
            <input type="hidden" name="action_type" value="registration">
            <span class="input_container">
                <label for="firstname">Etunimi</label>
                <input type="text" id="firstname" name="firstname" />
            </span>
            <span class="input_container">
                <label for="lastname">Sukunimi</label>
                <input type="text" id="lastname" name="lastname" />
            </span>
            <span class="input_container">
                <label for="email">Sähköposti</label>
                <input type="text" id="email" name="email" />
            </span>
            <input type="submit" class="submit" value="Luo tunnus" />
        </form>
    </div>
</div>
<?php
}
?>
</div>