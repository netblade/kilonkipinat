<div id="fi_kilonkipinat_accountregistration_wrapper">
<h1>Rekisteröinti</h1>
<h2>Sähköpostiosoitteen varmistus</h2>
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
</div>