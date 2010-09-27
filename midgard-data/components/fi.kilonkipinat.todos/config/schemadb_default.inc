'default' => array
(
    'description' => 'nakki',
    'fields'      => array
    (
        'title' => Array
        (
            'title' => 'title',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'deadline' => array
        (
            'title' => 'Parasta ennen',
            'storage' => 'deadline',
            'type' => 'date',
            'type_config' => array
            (
                'storage_type' => 'ISO'
            ),
            'widget' => 'jsdate',
            'widget_config' => array
            (
                'hide_seconds' => true,
                'show_time' => false,
            ),
        ),
        'weight' => array
        (
            'title' => 'Paino',
            'storage' => 'weight',
            'type' => 'select',
            'type_config' => array
            (
                'options' => array(
                    FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_ULTRALIGHT => 'weight_'.FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_ULTRALIGHT,
                    FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_LIGHT => 'weight_'.FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_LIGHT,
                    FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_MEDIUM => 'weight_'.FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_MEDIUM,
                    FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_HEAVY => 'weight_'.FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_HEAVY,
                    FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_SUPERHEAVY => 'weight_'.FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_SUPERHEAVY,
                ),
                'allow_other' => false,
                'allow_multiple' => false,
            ),
            'widget' => 'select',
        ),
        'content' => Array
        (
            'title' => 'Kuvaus',
            'storage' => 'content',
            'required' => true,
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html'
            ),
            'widget' => 'tinymce',
        ),
        'person' => array
        (
            'title' => 'Nakitettava henkilö',
            'storage' => 'person',
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
                'class'       => 'fi_kilonkipinat_account_person_dba',
                'component'   => 'fi.kilonkipinat.account',
                'titlefield'  => 'nickname',
                'id_field'     => 'id',
                'idfield'     => 'id',
                'searchfields' => array
                (
                    'firstname',
                    'lastname',
                    'nickname',
                ),
                'constraints' => array
                (
                    array
                    (
                        'field' => 'lastname',
                        'op' => '<>',
                        'value' => '',
                    ),
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
                    array
                    (
                        'name' => 'nickname',
                        'title' => $_MIDCOM->i18n->get_string('nickname', 'midcom'),
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
        'grp' => array
        (
            'title' => 'Nakitettava ryhmä',
            'storage' => 'grp',
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
                'id_field'     => 'id',
                'idfield'     => 'id',
                'searchfields' => array
                (
                    'official',
                ),
                'constraints' => array
                (
                    array
                    (
                        'field' => 'official',
                        'op' => '<>',
                        'value' => '',
                    ),
                ),
                'result_headers' => array
                (
                    array
                    (
                        'name' => 'official',
                        'title' => $_MIDCOM->i18n->get_string('name', 'midcom'),
                    ),
                ),
                'orders' => array
                (
                    array
                    (
                        'official' => 'ASC',
                    ),
                ),
            ),
        ),
        'event' => array
        (
            'title' => 'Liittyy tapahtumaan',
            'storage' => 'event',
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
                'class'       => 'fi_kilonkipinat_events_event_dba',
                'component'   => 'fi.kilonkipinat.events',
                'titlefield'  => 'title',
                'id_field'     => 'id',
                'idfield'     => 'id',
                'searchfields' => array
                (
                    'title',
                    'content',
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
                    array
                    (
                        'name' => 'start',
                        'title' => $_MIDCOM->i18n->get_string('start', 'midcom'),
                    ),
                    array
                    (
                        'name' => 'end',
                        'title' => $_MIDCOM->i18n->get_string('end', 'midcom'),
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
        'supervisor' => array
        (
            'title' => 'Valvoja',
            'storage' => 'supervisor',
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
                'class'       => 'fi_kilonkipinat_account_person_dba',
                'component'   => 'fi.kilonkipinat.account',
                'titlefield'  => 'nickname',
                'id_field'     => 'id',
                'idfield'     => 'id',
                'searchfields' => array
                (
                    'firstname',
                    'lastname',
                    'nickname',
                ),
                'constraints' => array
                (
                    array
                    (
                        'field' => 'lastname',
                        'op' => '<>',
                        'value' => '',
                    ),
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
                    array
                    (
                        'name' => 'nickname',
                        'title' => $_MIDCOM->i18n->get_string('nickname', 'midcom'),
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
        'category' => array
        (
            'title' => 'Kategoriat',
            'storage' => 'category',
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array(
                'require_corresponding_option' => false,
                'options' => fi_kilonkipinat_todos_viewer::getCategories(),
                'allow_other' => false,
                'allow_multiple' => true,
                'multiple_storagemode' => 'imploded_wrapped',
            ),    
            'widget_config' => Array 
            ( 
                'height' => count(explode(',', $this->_config->get('categories'))),
            ),
        ),
    ),
),

