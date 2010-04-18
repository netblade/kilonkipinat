'name' => 'fi.kilonkipinat.accountregistration',
'icon' => 'fi.kilonkipinat.accountregistration/user_add.png',
'purecode' => false,
'version' => '8.09.8.0',
'state' => 'stable',
'privileges' => array(),
'class_definitions' => array
(
    'midcom_dba_classes.inc',
),
'package.xml' => array
(
    'summary' => 'Small component for registry and password recovery',
    'description' => 'Small component for registry and password recovery',
    'maintainers' => array
    (
        'netblade' => array
        (
            'name' => 'Oskari Kokko',
            'email' => 'oskari.kokko@iki.fi',
            'role' => 'lead',
            'active' => 'yes',
        ),
    ),
    'dependencies' => Array
    (
        'midcom.helper.datamanager2' => array(),
        'org.openpsa.mail' => array(),
    ),
),
'customdata' => array
(
    'midcom.services.cron' => array
    (
        array
        (
            'handler' => 'fi_kilonkipinat_accountregistration_cron_clearold',
            'recurrence' => MIDCOM_CRON_DAY,
        ),
    ),
),