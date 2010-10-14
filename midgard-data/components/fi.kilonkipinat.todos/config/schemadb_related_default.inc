'default' => array
(
    'description' => 'tehtävä',
    'fields'      => array
    (
        'parentTodo' => array
        (
            'title' => 'Isäntä',
            'storage' => 'parentTodo',
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
                'class'       => 'fi_kilonkipinat_todos_todoitem_dba',
                'component'   => 'fi.kilonkipinat.todos',
                'titlefield'  => 'nickname',
                'id_field'     => 'id',
                'idfield'     => 'id',
                'searchfields' => array
                (
                    'title',
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
        'childTodo' => array
        (
            'title' => 'Lapsi',
            'storage' => 'childTodo',
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
                'class'       => 'fi_kilonkipinat_todos_todoitem_dba',
                'component'   => 'fi.kilonkipinat.todos',
                'titlefield'  => 'nickname',
                'id_field'     => 'id',
                'idfield'     => 'id',
                'searchfields' => array
                (
                    'title',
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
        'linkType' => array
        (
            'title' => 'Tyyppi',
            'storage' => 'linkType',
            'type' => 'select',
            'type_config' => array
            (
                'require_corresponding_option' => false,
                'options' => array(
                    
                ),
                'allow_other' => false,
                'allow_multiple' => false,
            ),
            'widget' => 'select',
        ),
    ),
),