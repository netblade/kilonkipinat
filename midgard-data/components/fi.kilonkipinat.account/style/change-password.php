<?php
$person = $data['person'];

?>
<h1>Vaihda salasana</h1>
<?php
if ($data['messages'] != '') {
    echo $data['messages'];
    echo "<br /><br />";
}
?>
<form method="POST">
    <div class="fi_kilonkipinat_account_form_field">
        <label for="old_pass">Vanha salasana</label>
        <input type="password" name="old_pass" id="old_pass" />
    </div>
    <div class="fi_kilonkipinat_account_form_field">
        <label for="new_pass">Uusi salasana</label>
        <input type="password" name="new_pass" id="new_pass" />
    </div>
    <div class="fi_kilonkipinat_account_form_field">
        <label for="new_pass2">Uusi salasana, varmistus</label>
        <input type="password" name="new_pass2" id="new_pass2" />
    </div>
    <div class="fi_kilonkipinat_account_form_field">
        <input type="submit" value="Vaihda salasana">
    </div>
</form>