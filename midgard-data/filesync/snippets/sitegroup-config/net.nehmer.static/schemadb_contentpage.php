'default' => array
(
    'description' => 'article',
    'fields'      => array
    (
        'name' => Array
        (
            // COMPONENT-REQUIRED
            'title' => 'url name',
            'storage' => 'name',
            'type' => 'urlname',
            'widget' => 'text',
        ),
        'title' => Array
        (
            // COMPONENT-REQUIRED
            'title' => 'title',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'content' => Array
        (
            // COMPONENT-REQUIRED
            'title' => 'content',
            'storage' => 'content',
            'type' => 'text',
            'type_config' => Array
            (
                'output_mode' => 'html',
            ),
            'widget' => 'tinymce',
        ),
        'downloads' => Array
        (
            'title' => 'Tiedostot',
            'storage' => null,
            'type' => 'blobs',
            'type_config' => array(
                'sortable' => true,
            ),
            'widget' => 'downloads',
        ),
        'abstract' => Array
        (
            'title' => 'huomiot',
            'storage' => 'abstract',
            'type' => 'text',
            'type_config' => Array
            (
                'output_mode' => 'markdown',
            ),
            'widget' => 'textarea',
        ),
    ),
), // default