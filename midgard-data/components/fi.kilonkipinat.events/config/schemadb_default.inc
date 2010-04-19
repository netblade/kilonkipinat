'default' => array
(
    'description' => 'event',
    'fields'      => array
    (
        'name' => Array
        (
            'title' => 'url name',
            'storage' => 'name',
            'type' => 'urlname',
            'widget' => 'text',
        ),
        'title' => Array
        (
            'title' => 'title',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'start' => array
        (
            // COMPONENT-REQUIRED
            'title' => 'start',
            'storage' => 'start',
            'type' => 'date',
            'type_config' => array
            (
                'storage_type' => 'ISO'
            ),
            'widget' => 'jsdate',
        ),
        'end' => array
        (
            // COMPONENT-REQUIRED
            'title' => 'end',
            'storage' => 'end',
            'type' => 'date',
            'type_config' => array
            (
                'storage_type' => 'ISO',
                'earlier_field' => 'start',
            ),
            'widget' => 'jsdate',
        ),
        'content' => Array
        (
            'title' => 'content',
            'storage' => 'content',
            'required' => true,
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html'
            ),
            'widget' => 'tinymce',
        ),
    ),
),

