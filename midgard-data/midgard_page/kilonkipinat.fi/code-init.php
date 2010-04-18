<?php 

$GLOBALS['midcom_config_local']['midcom_root_topic_guid'] = "1df0a0af3cbefba0a0a11dfa1744ba225a793049304"; 
$GLOBALS['midcom_config_local']['log_level'] = 2; 
$GLOBALS['midcom_config_local']['log_filename'] = '/var/log/midgard/midcom/kilonkipinat.fi_80.log'; 
$GLOBALS['midcom_config_local']['cache_base_directory'] = '/var/cache/midgard/midcom/'; 


?><(code-init-before-midcom)><?php

define(MIDCOM_ROOT, '/usr/share/php/midcom/lib');

require MIDCOM_ROOT . '/midcom.php'; 

?><(code-init-after-midcom)><?php 

$_MIDCOM->codeinit(); 

?>
