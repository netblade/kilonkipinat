'config' => array
(
    'description' => 'Default Configuration Schema',
    'fields'      => array
    (
        'group_for_emails' => array
        (
            'title' => 'Ryhmä sähköpostikäyttäjiä varten',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.emailmappings',
                'name' => 'group_for_emails',
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
                'component'   => 'fi.kilonkipinat.emailmappings',
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
