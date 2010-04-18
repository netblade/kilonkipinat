<?php
$_MIDCOM->enable_jquery();

$_MIDCOM->i18n->set_language('fi', false);

$_MIDCOM->componentloader->load('fi.kilonkipinat.website');

// check if we have just logged in and do things related to login
fi_kilonkipinat_website::check_login();

?>
