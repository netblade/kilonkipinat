'default' => array
(
    'description' => 'Pestinimike',
    'fields'      => array
    (
        'name' => Array
        (
            'title' => 'name',
            'storage' => 'name',
            'required' => true,
            'type' => 'urlname',
            'widget' => 'text',
        ),
        'title' => Array
        (
            'title' => 'Otsikko',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'shorttitle' => Array
        (
            'title' => 'Lyhyt otsikko',
            'storage' => 'shorttitle',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'jobgroup' => array
        (
            'title' => 'Pestiryhmä',
            'storage' => 'jobgroup',
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
                'class'       => 'fi_kilonkipinat_account_jobhistory_jobgroup_dba',
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
    ),
),