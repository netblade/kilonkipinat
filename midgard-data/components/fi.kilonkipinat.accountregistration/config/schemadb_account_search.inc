'default' => array
(
    'description' => 'user to join',
    'fields'      => array
    (
        'user_to_join' => array
        (
            'title' => 'Henkilö, johon anomus liitetään',
            'storage' => array
            (
                'location' => 'parameter',
                'name' => 'user_to_join',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'require_corresponding_option' => false,
                'options' => array(),
                'allow_other' => true,
                'allow_multiple' => false,
            ),
            'widget' => 'chooser',
            'widget_config' => array
            (
                'class'       => 'midcom_db_person',
                'component'   => 'fi.kilonkipinat.accountregistration',
                'titlefield'  => 'rname',
                'id_field'     => 'guid',
                'searchfields' => array
                (
                    'rname',
                    'firstname',
                    'lastname',
                    'username',
                    'email',
                ),
                'constraints' => array
                (
/*                    array
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
                    ),*/
                ),
                'result_headers' => array
                (
                    array
                    (
                        'name' => 'rname',
                        'title' => $_MIDCOM->i18n->get_string('name', 'midcom'),
                    ),
                    array
                    (
                        'name' => 'username',
                        'title' => $_MIDCOM->i18n->get_string('username', 'midcom'),
                    ),
                    array
                    (
                        'name' => 'email',
                        'title' => $_MIDCOM->i18n->get_string('email', 'midcom'),
                    ),
                ),
                'generate_path_for' => '',
                'orders' => array
                (
                    array
                    (
                        'rname' => 'ASC',
                    ),
                    array
                    (
                        'email' => 'ASC',
                    ),
                ),
            ),
        ),
    ),
),

