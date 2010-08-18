// <?php // hack to trigger syntax-highlighting
'name' => 'fi.kilonkipinat.brainstorm',
'purecode' => false,
'version' => '8.09.8',
'state' => 'stable',
'privileges' => array
(
    'moderation' => 'MIDCOM_PRIVILEGE_DENY',
),
'class_definitions' => array
(
    'midcom_dba_classes.inc',
),
'package.xml' => array
(
    'summary' => 'Brainstorm-component for Kilon Kipinät',
    'description' => 'Brainstorm-component for Kilon Kipinät',
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
        'net.nehmer.comments' => array(),
        'net.nemein.favourites' => array(),
        'org.openpsa.qbpager' => array(),
    ),
),
'customdata' => array
(
    'midcom.services.cron' => array
    (
        array
        (
            'handler' => 'org_maemo_brainstorm_cron_karma',
            'recurrence' => MIDCOM_CRON_DAY,
        ),
    ),
),