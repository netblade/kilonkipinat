'default' => array
(
    'description' => 'Pesti',
    'fields'      => array
    (
        'person' => array
        (
            'title' => 'Kipinä',
            'storage' => 'person',
            'type' => 'select',
            'required' => true,
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
                'class'       => 'fi_kilonkipinat_account_person_dba',
                'component'   => 'fi.kilonkipinat.account',
                'titlefield'  => 'title',
                'id_field'     => 'id',
                'idfield'     => 'id',
                'searchfields' => array
                (
                    'title',
                    'name',
                ),
                'constraints' => array
                (
                    array
                    (
                        'field' => 'firstname',
                        'op' => '<>',
                        'value' => '',
                    ),
                ),
                'result_headers' => array
                (
                    array
                    (
                        'name' => 'firstname',
                        'title' => $_MIDCOM->i18n->get_string('firstname', 'midcom'),
                    ),
                    array
                    (
                        'name' => 'lastname',
                        'title' => $_MIDCOM->i18n->get_string('lastname', 'midcom'),
                    ),
                ),
                'orders' => array
                (
                    array
                    (
                        'lastname' => 'ASC',
                        'firstname' => 'ASC',
                    ),
                ),
            ),
        ),
        'jobtitle' => array
        (
            'title' => 'Pestinimike',
            'storage' => 'jobtitle',
            'type' => 'select',
            'required' => true,
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
                'class'       => 'fi_kilonkipinat_account_jobhistory_jobtitle_dba',
                'component'   => 'fi.kilonkipinat.account',
                'titlefield'  => 'title',
                'id_field'     => 'id',
                'idfield'     => 'id',
                'searchfields' => array
                (
                    'title',
                    'name',
                ),
                'constraints' => array
                (
                    array
                    (
                        'field' => 'title',
                        'op' => '<>',
                        'value' => '',
                    ),
                ),
                'result_headers' => array
                (
                    array
                    (
                        'name' => 'title',
                        'title' => $_MIDCOM->i18n->get_string('title', 'midcom'),
                    ),
                ),
                'orders' => array
                (
                    array
                    (
                        'title' => 'ASC',
                    ),
                ),
            ),
        ),
        'start' => array
        (
            'title' => 'Alkoi',
            'storage' => 'start',
            'type' => 'date',
            'required' => true,
            'type_config' => array
            (
                'storage_type' => 'ISO'
            ),
            'widget' => 'jsdate',
            'widget_config' => array
            (
                'show_time' => false,
                'hide_seconds' => true,
            ),
        ),
        'end' => array
        (
            'title' => 'Loppuu',
            'storage' => 'end',
            'type' => 'date',
            'type_config' => array
            (
                'storage_type' => 'ISO',
            ),
            'widget' => 'jsdate',
            'widget_config' => array
            (
                'show_time' => false,
                'hide_seconds' => true,
            ),
        ),
        'description' => Array
        (
            'title' => 'Kuvaus',
            'storage' => 'description',
            'type' => 'text',
            'type_config' => array(
                'output_mode' => 'html',
            ),
            'widget' => 'tinymce',
        ),
    ),
),