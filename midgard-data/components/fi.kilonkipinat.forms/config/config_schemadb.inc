'config' => array 
(
    'description' => 'Default Configuration Schema',
    'fields'      => array
    ( 
        'list_count' => array
        (
            'title' => 'Etusivun listauksessa olevat omat ',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'net.nehmer.static',
                'name' => 'list_count',
            ),
            'type' => 'text',
            'widget' => 'text',
        ),
        
    )
),
