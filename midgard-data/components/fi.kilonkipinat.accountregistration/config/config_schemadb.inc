'config' => array 
(
    'description' => 'Default Configuration Schema',
    'fields'      => array
    (
        'enable_account_creation' => array
        (
            'title' => 'enable account creation',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.accountregistration',
                'name' => 'enable_account_creation',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '' => 'default',
                    '1' => 'enable',
                    '-1' => 'disable',
                ),
                'allow_other' => false,
                'allow_multiple' => false,
            ),
            'widget' => 'select',
            'start_fieldgroup' => array
            (
                'title' => 'account creation'
            ),
        ),
        'require_approval' => array
        (
            'title' => 'require approval',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.accountregistration',
                'name' => 'require_approval',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '' => 'default',
                    '1' => 'enable',
                    '-1' => 'disable',
                ),
                'allow_other' => false,
                'allow_multiple' => false,
            ),
            'widget' => 'select',
            'start_fieldgroup' => array
            (
                'title' => 'account creation'
            ),
        ),
        'username_generation' => array
        (
            'title' => 'username generation',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.accountregistration',
                'name' => 'username_generation',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    'firstname.lastname' => 'firstname.lastname',
                    'firstname_lastname' => 'firstname_lastname',
                    'email' => 'email',
                ),
                'allow_other' => false,
                'allow_multiple' => false,
            ),
            'widget' => 'select',
        ),
/*        'group_to_add' => array
        (
            'title' => 'Ryhmä, johon uudet käyttäjät liitetään',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.accountregistration',
                'name' => 'group_to_add',
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
                'class'       => 'midcom_db_group',
                'component'   => 'fi.kilonkipinat.accountregistration',
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
        ),*/
        'password_length' => array
        (
            'title' => 'Salasanan pituus',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.accountregistration',
                'name' => 'password_length',
            ),
            'type' => 'text',
            'widget' => 'text',
            'end_fieldgroup' => 1,
        ),
        'enable_password_reset' => array
        (
            'title' => 'enable password reset',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.accountregistration',
                'name' => 'enable_password_reset',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '' => 'default',
                    '1' => 'enable',
                    '-1' => 'disable',
                ),
                'allow_other' => false,
                'allow_multiple' => false,
            ),
            'widget' => 'select',
        ),
        'mail_sender_address' => array
        (
            'title' => 'mail sender address',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.accountregistration',
                'name' => 'mail_sender_address',
            ),
            'type' => 'text',
            'widget' => 'text',
        ),
        'mail_sender_title' => array
        (
            'title' => 'mail sender title',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.accountregistration',
                'name' => 'mail_sender_title',
            ),
            'type' => 'text',
            'widget' => 'text',
        ),
        'moderator' => array
        (
            'title' => 'Henkilö, jolle lähetetään sähköposti tunnuspyynnöistä',
            'storage' => array
            (
                'location' => 'configuration',
                'domain' => 'fi.kilonkipinat.accountregistration',
                'name' => 'moderator',
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
