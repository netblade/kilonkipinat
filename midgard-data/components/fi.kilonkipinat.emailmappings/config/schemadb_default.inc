'default' => array
(
    'description' => 'sähköpostiohjaus',
    'fields'      => array
    (
        'name' => Array
        (
            'title' => 'url name',
            'storage' => 'name',
            'type' => 'urlname',
            'widget' => 'text',
        ),
        'persons' => array
        (
            'title' => 'Kenelle / keille sähköposti ohjataan',
            'storage' => 'persons',
            'type' => 'select',
            'type_config' => array
            (
                'require_corresponding_option' => false,
                'options' => array(),
                'allow_other' => false,
                'allow_multiple' => true,
                'multiple_storagemode' => 'imploded_wrapped',
            ),
            'widget' => 'chooser',
            'widget_config' => array
            (
                'class'       => 'midcom_db_person',
                'component'   => 'fi.kilonkipinat.emailmappings',
                'titlefield'  => 'official',
                'id_field'     => 'guid',
                'searchfields' => array
                (
                    'firstname',
                    'lastname',
                    'username',
                    'email',
                ),
                'constraints' => array
                (
                    array
                    (
                        'field' => 'username',
                        'op' => '<>',
                        'value' => '',
                    ),
                    array
                    (
                        'field' => 'email',
                        'op' => '<>',
                        'value' => '',
                    ),
                ),
                'result_headers' => array
                (
                    array
                    (
                        'name' => 'username',
                        'title' => $_MIDCOM->i18n->get_string('username', 'midcom'),
                    ),
                    array
                    (
                        'name' => 'rname',
                        'title' => $_MIDCOM->i18n->get_string('name', 'midcom'),
                    ),
                    array
                    (
                        'name' => 'email',
                        'title' => $_MIDCOM->i18n->get_string('email', 'midcom'),
                    ),
                ),
                'orders' => array
                (
                    array
                    (
                        'lastname' => 'ASC',
                    ),
                    array
                    (
                        'firstname' => 'ASC',
                    ),
                    array
                    (
                        'username' => 'ASC',
                    ),
                ),
            ),
        ),
    ),
),

