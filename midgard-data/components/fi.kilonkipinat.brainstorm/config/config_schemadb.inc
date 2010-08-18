'config' => array 
(
    'description' => 'Default Configuration Schema',
    'fields'      => array
    ( 
        'sort_order' => array
        (
            'title' => 'sort_order',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'net.nehmer.static',
                'name' => 'sort_order',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '' => 'default setting',
                    'reverse score' => 'reverse score',
                    'score' => 'score',
                    'reverse title' => 'reverse title',
                    'title' => 'title',
                    'reverse created' => 'reverse created',
                    'created' => 'created',
                ),
            ),
            'widget' => 'select',
        ),
        
    )
),
