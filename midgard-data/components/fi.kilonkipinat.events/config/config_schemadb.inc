'config' => array 
(
    'description' => 'Default Configuration Schema',
    'fields'      => array
    ( 
        /**** Display settings ****/
        'index_count' => array
        (
            'title' =>  'index count',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'net.nemein.calendar',
                'name' => 'index_count',
            ),
            'type' => 'text',
            'widget' => 'text',
            'start_fieldset' => array
            (
                'title' => 'display settings',
            ),
        ),
        
        'categories' => array
        (
            'title' =>  'categories',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'net.nemein.calendar',
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
                'domain' => 'net.nemein.calendar',
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
                'domain' => 'net.nemein.calendar',
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
                'domain' => 'net.nemein.calendar',
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
        net_nemein_rss_helpers::default_rss_config_schema_fields('fi.kilonkipinat.events')
    )
),
