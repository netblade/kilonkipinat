'default' => array
(
    'description' => 'Paikka',
    'fields'      => array
    (
        'title' => Array
        (
            'title' => 'Paikan nimi',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'content' => Array
        (
            'title' => 'Kuvaus (julkinen)',
            'storage' => 'content',
            'required' => true,
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html'
            ),
            'widget' => 'tinymce',
            'start_fieldset' => array
            (
                'title' => 'Kuvaus',
            ),
        ),
        'contentprivate' => Array
        (
            'title' => 'Sisältö (näkyy vain käyttäjille)',
            'storage' => 'contentprivate',
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html'
            ),
            'widget' => 'tinymce',
        ),
        'url' => Array
        (
            'title' => 'URL',
            'storage' => 'url',
            'type' => 'text',
            'widget' => 'text',
        ),
        'location' => array
        (
            'title' => 'Tarkka paikka',
            'storage' => 'location',
            'type' => 'position',
            'widget' => 'position',
            'widget_config' => Array
            (
                'service' => 'yahoo', //Possible values are city, geonames, yahoo
            ),
        ),
        'locationzoom' => Array
        (
            'title' => 'Kartan zoom',
            'storage' => 'locationzoom',
            'required' => true,
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array
            (
                'allow_multiple' => false,
                'allow_other' => false,
                'options' => array
                (
                    10 => '10',
                    11 => '11',
                    12 => '12',
                    13 => '13 (about 10 kilsaa)',
                    14 => '14',
                    15 => '15 (about kilsa)',
                    16 => '16',
                    17 => '17',
                ),
            ),
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
    ),
),