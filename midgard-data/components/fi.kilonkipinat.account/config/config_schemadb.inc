'config' => array
(
    'description' => 'Default Configuration Schema',
    'fields'      => array
    ( 
        'password_min_length' => array
        (
            'title' => 'Salasanan minimipituus',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.account',
                'name' => 'password_min_length',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '' => 'default setting',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                ),
            ),
            'widget' => 'select',
        ),
        'root_group_to_show' => array
        (
            'title' => 'Sivuston käyttäjien perusryhmä',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.account',
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
                'component'   => 'fi.kilonkipinat.account',
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
        'group_for_emails' => array
        (
            'title' => 'Ryhmä sähköpostikäyttäjiä varten',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.account',
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
                'component'   => 'fi.kilonkipinat.account',
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
