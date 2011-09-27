'config' => array 
(
    'description' => 'Default Configuration Schema',
    'fields'      => array
    (
        'index_count' => array
        (
            'title' =>  'index count',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.events',
                'name' => 'index_count',
            ),
            'type' => 'text',
            'widget' => 'text',
            'start_fieldset' => array
            (
                'title' => 'display settings',
            ),
        ),
        'kisa' => array
        (
            'title' =>  'kisa',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.events',
                'name' => 'kisa',
            ),
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array
            (
                'allow_multiple' => false,
                'allow_other' => false,
                'options' => array
                (
                    0 => 'Ei (näytä sekä että)',
                    1 => 'Ei (älä näytä KiSa:n tapahtumia)',
                    2 => 'Kyllä (näytä sekä että)',
                    3 => 'KiSa (älä näytä KKp:n tapahtumia',
                ),
            ),
        ),
        'categories' => array
        (
            'title' =>  'categories',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.events',
                'name' => 'categories',
            ),
            'type' => 'text',
            'widget' => 'text',
        ),
        'enable_filters' => array
        (
            'title' =>  'enable get filters',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.events',
                'name' => 'enable_filters',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '' => 'default setting',
                    '1' => 'yes',
                    '0' => 'no',
                ),
            ),
            'widget' => 'select',
        ),
        'archive_year_order' => array
        (
            'title' =>  'archive year order',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.events',
                'name' => 'archive_year_order',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '' => 'default setting',
                    'DESC' => 'DESC',
                    'ASC' => 'ASC',
                ),
            ),
            'widget' => 'select',
            'end_fieldset' => '',
        ),
        'rss_subscription_enable' => array
        (
            'title' =>  'enable rss subscription',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.events',
                'name' => 'rss_subscription_enable',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '' => 'default setting',
                    '1' => 'yes',
                    '0' => 'no',
                ),
            ),
            'widget' => 'select',
            'start_fieldset' => array
            (
               'title' => 'rss subscriptions',
            ),
            'end_fieldset' => 1,
        ),
        'rss_enable' => array
        (
            'title' => $_MIDCOM->i18n->get_string('rss_enable', 'net.nemein.rss'),
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.events',
                'name' => 'rss_enable',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '' => 'default setting',
                    '1' => 'yes',
                    '0' => 'no',
                ),
            ),
            'widget' => 'select',
            'start_fieldgroup' => array
            (
                'title' =>  $_MIDCOM->i18n->get_string('rss export settings', 'net.nemein.rss'),
            ),
        ),
        'rss_count' => array
        (
            'title' => $_MIDCOM->i18n->get_string('rss_count', 'net.nemein.rss'),
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.events',
                'name' => 'rss_count',
            ),
            'type' => 'text',
            'widget' => 'text',
        ),
        'rss_title' => array
        (
            'title' => $_MIDCOM->i18n->get_string('rss_title', 'net.nemein.rss'),
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.events',
                'name' => 'rss_title',
            ),
            'type' => 'text',
            'widget' => 'text',
        ),
        'rss_description' => array
        (
            'title' => $_MIDCOM->i18n->get_string('rss_description', 'net.nemein.rss'),
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.events',
                'name' => 'rss_description',
            ),
            'type' => 'text',
            'widget' => 'text',
        ),
        'rss_webmaster' => array
        (
            'title' => $_MIDCOM->i18n->get_string('rss_webmaster', 'net.nemein.rss'),
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.events',
                'name' => 'rss_webmaster',
            ),
            'type' => 'text',
            'widget' => 'text',
        ),
        'rss_language' => array
        (
            'title' => $_MIDCOM->i18n->get_string('rss_language', 'net.nemein.rss'),
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.events',
                'name' => 'rss_language',
            ),
            'type' => 'text',
            'widget' => 'text',
        ),
    ),
),
