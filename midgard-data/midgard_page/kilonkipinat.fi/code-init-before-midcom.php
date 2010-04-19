<?php
$GLOBALS['midcom_config_local']['cache_module_content_uncached'] = true;

$GLOBALS['midcom_config_local']['login_redirect_url'] = $_MIDGARD['self'] . 'extranet/';

$GLOBALS['midcom_config_local']['auth_save_prev_login'] = true;

// Indexer-settings
$GLOBALS['midcom_config_local']['indexer_backend'] = 'solr';
$GLOBALS['midcom_config_local']['indexer_xmltcp_host'] = 'localhost';
$GLOBALS['midcom_config_local']['indexer_xmltcp_port'] = 8180;
$GLOBALS['midcom_config_local']['indexer_index_name'] = 'kilonkipinat.fi';

$GLOBALS['midcom_config_local']['indexer_reindex_allowed_ips'] = array(
'127.0.0.1', '83.145.206.183', $_SERVER['SERVER_ADDR'], '83.150.90.73');

$GLOBALS['midcom_config_local']['attachment_cache_enabled'] = true;
$GLOBALS['midcom_config_local']['attachment_cache_root'] = '/var/lib/midgard/vhosts/kilonkipinat.fi/80/midcom-static/static';
$GLOBALS['midcom_config_local']['attachment_cache_url'] = '/midcom-static/static';

//Oskun koti-ip

if ($_SERVER['REMOTE_ADDR'] == '83.145.206.183')
{
    $GLOBALS['midcom_config_local']['log_level'] = 5; 
    $GLOBALS['midcom_config_local']['log_filename'] = '/var/log/midgard/midcom/osku_kilonkipinat.fi_80.log';
}

$GLOBALS['midcom_config_local']['auth_success_callback'] = 'fi_kilonkipinat_after_login';
mgd_include_snippet('/kilonkipinat.fi/login_related');

?>
