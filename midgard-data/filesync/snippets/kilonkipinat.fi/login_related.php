<?php
function fi_kilonkipinat_after_login()
{
    $GLOBALS['fi_kilonkipinat_website_login_detected'] = true;
}
?>