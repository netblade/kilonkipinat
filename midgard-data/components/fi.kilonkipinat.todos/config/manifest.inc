// <?php // hack to trigger syntax-highlighting
'name' => 'fi.kilonkipinat.todos',
'purecode' => false,
'version' => '8.09.8',
'state' => 'stable',
'privileges' => array(),
'class_definitions' => array
(
    'midcom_dba_classes.inc',
),
'package.xml' => array
(
    'summary' => 'Todo-listings for Kilon Kipinät ry',
    'description' => 'Todo-listings for Kilon Kipinät ry',
    'maintainers' => array
    (
        'netblade' => array
        (
            'name' => 'Oskari Kokko',
            'email' => 'oskari.kokko@iki.fi',
            'role' => 'lead',
        ),
    ),
    'dependencies' => array
    (
        'midcom.helper.datamanager2' => array(),
        'fi.kilonkipinat.account' => array(),
        'org.openpsa.notifications' => array(),
    ),
),
'customdata' => array
(
    'org.openpsa.notifications' => array
    (
        'subscribe' => array
        (
            'default' => 'email',
        ),
    )
),