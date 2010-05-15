'name' => 'fi.kilonkipinat.account',
'icon' => 'fi.kilonkipinat.account/group.png',
'purecode' => false,
'version' => '8.09.8.0',
'state' => 'stable',
'privileges' => array
(
    'jobhistory_manage' => 'MIDCOM_PRIVILEGE_DENY',
),
'class_definitions' => array
(
    'midcom_dba_classes.inc',
),
'package.xml' => array
(
    'summary' => 'account component for kilonkipinat.fi',
    'description' => 'account component for kilonkipinat.fi',
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
    /* Define what modules this module depends on.  */
    'dependencies' => Array
    (
        'midcom.helper.datamanager2' => array(),
        'fi.kilonkipinat.website' => array(),
        'org.openpsa.mail' => array(),
    ),
),