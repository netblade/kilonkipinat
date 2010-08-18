// <?php // hack to trigger syntax-highlighting
'name' => 'fi.kilonkipinat.forms',
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
    'summary' => 'Fill up forms for kilonkipinat.fi',
    'description' => 'Fill up forms for kilonkipinat.fi',
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
        'fi.kilonkipinat.account' => array(),
        'org.openpsa.mail' => array(),
    ),
),


