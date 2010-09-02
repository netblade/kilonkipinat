'default' => array
(
    'description' => 'article',
    'fields'      => array
    (
        'name' => array
        (
            // COMPONENT-REQUIRED
            'title' => 'url name',
            'storage' => 'name',
            'type' => 'urlname',
            'widget' => 'text',
        ),
        'title' => array
        (
            // COMPONENT-REQUIRED
            'title' => 'title',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'content' => array
        (
            // COMPONENT-REQUIRED
            'title' => 'content',
            'storage' => 'content',
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html',
            ),
            'widget' => 'tinymce',
        ),
        'downloads' => array
        (
            'title' => 'Tiedostot',
            'storage' => null,
            'type' => 'blobs',
            'type_config' => array(
                'sortable' => true,
            ),
            'widget' => 'downloads',
        ),
        'abstract' => array
        (
            'title' => 'huomiot',
            'storage' => 'abstract',
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'markdown',
            ),
            'widget' => 'textarea',
        ),
    ),
), // default