'name' => 'fi.kilonkipinat.emailmappings',
'icon' => 'fi.kilonkipinat.emailmappings/email_go.png',
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
    'summary' => 'Simple component for mapping kilonkipinat.fi emails',
    'description' => 'Simple component for mapping kilonkipinat.fi emails',
    'maintainers' => array
    (
        'netblade' => array
        (
            'name' => 'Firstname Lastname',
            'email' => 'user@example.net',
            'role' => 'lead',
        ),
    ),
    /* Define what modules this module depends on.  */
    'dependencies' => array
    (
        'midcom.helper.datamanager2' => array(),
    ),
),
'customdata' => array
(
    'midcom.services.cron' => array
    (
        array
        (
            'handler' => 'fi_kilonkipinat_emailmappings_cron_emailmapper',
            'recurrence' => MIDCOM_CRON_HOUR,
        ),
    ),
),