'config' => array 
(
    'description' => 'Default Configuration Schema', /* This is a topic */
    'fields'      => array
    ( 
        'root_group_to_show' => array
        (
            'title' => 'Sivuston käyttäjien perusryhmä',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.todos',
                'name' => 'root_group_to_show',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'require_corresponding_option' => false,
                'options' => array(),
                'allow_other' => false,
                'allow_multiple' => false,
            ),
            'widget' => 'chooser',
            'widget_config' => array
            (
                'class'       => 'midcom_db_group',
                'component'   => 'fi.kilonkipinat.todos',
                'titlefield'  => 'official',
                'id_field'     => 'guid',
                'searchfields' => array
                (
                    'official',
                    'name',
                ),
                'constraints' => array
                (
                    array
                    (
                        'field' => 'official',
                        'op' => '<>',
                        'value' => '',
                    ),
                    array
                    (
                        'field' => 'up',
                        'op' => '<>',
                        'value' => '0',
                    ),
                ),
                'result_headers' => array
                (
                    array
                    (
                        'name' => 'official',
                        'title' => $_MIDCOM->i18n->get_string('official', 'midcom'),
                    ),
                    array
                    (
                        'name' => 'name',
                        'title' => $_MIDCOM->i18n->get_string('name', 'midcom'),
                    ),
                ),
                'generate_path_for' => 'official',
                'orders' => array
                (
                    array
                    (
                        'official' => 'ASC',
                    ),
                    array
                    (
                        'name' => 'ASC',
                    ),
                ),
            ),
        ),
    )
),
