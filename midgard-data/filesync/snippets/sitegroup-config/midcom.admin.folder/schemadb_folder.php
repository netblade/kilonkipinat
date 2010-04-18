'default' => array
(
    'description' => 'topic',
    'l10n_db' => 'midcom.admin.folder',
    'fields' => array
    (
        'name' => array
        (
            'title' => 'name',
            'storage' => 'name',
            'type' => 'text',
            'widget' => 'text',
            'start_fieldset' => array (
                'class' => 'admin',
                'title' => 'Admin content',
            ),
        ),
        'title' => array
        (
            'title' => 'title',
            'storage' => 'extra',
            'type' => 'text',
            'widget' => 'text',
            'required' => true,
        ),
        'component' => array
        (
            'title' => 'component',
            'storage' => 'component',
            'type' => 'select',
            'type_config' => array
            (
                'options' => midcom_admin_folder_folder_management::list_components($_MIDCOM->get_context_data(MIDCOM_CONTEXT_COMPONENT)),
            ),
            'widget' => 'select',
        ),
        'style' => array
        (
            'title' => 'style template',
            'storage' => 'style',
            'type' => 'select',
            'type_config' => array
            (
                'options' => midcom_admin_folder_folder_management::list_styles(),
            ),
            'widget' => 'select',
        ),
        'style_inherit' => array
        (
            'title' => 'inherit style',
            'storage' => 'styleInherit',
            'type' => 'boolean',
            'widget' => 'checkbox',
        ),
        'nav_order' => array
        (
            'title' => 'nav order',
            'storage' => array
            (
                'location' => 'parameter',
                'domain' => 'midcom.helper.nav',
                'name' => 'nav_order',
            ),
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    MIDCOM_NAVORDER_DEFAULT => $_MIDCOM->i18n->get_string('default sort order', 'midcom.admin.folder'),
                    MIDCOM_NAVORDER_TOPICSFIRST => $_MIDCOM->i18n->get_string('folders first', 'midcom.admin.folder'),
                    MIDCOM_NAVORDER_ARTICLESFIRST => $_MIDCOM->i18n->get_string('pages first', 'midcom.admin.folder'),
                    MIDCOM_NAVORDER_SCORE => $_MIDCOM->i18n->get_string('by score', 'midcom.admin.folder'),
                ),
            ),
            'widget' => 'select',
            'end_fieldset' => array(),
        ),
/*        'topic_image_hide' => Array
        (
            'title' => "Hide image (don't inherit from parent topic)",
            'storage' => array(
                'location' => 'parameter',
            ),
            'required' => false,
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '-1' => 'Show',
                    '1' => 'Hide',
                ),
                'allow_other' => false,
                'allow_multiple' => false,
            ),
            'widget' => 'select',
            'start_fieldset' => array (
                'class' => 'topic_image',
                'title' => 'Topic image',
            ),
        ),
        "topic_image" => Array
        (
            'title' => 'Main image (672x250 px)',
            'storage' => null,
            'type' => 'image',
            'type_config' => Array
            (
                'filter_chain' => 'resize(672,350)',
                'keep_original' => true,
            ),
            'widget' => 'image',
            'index_method' => 'noindex',
        ),
        'topic_image_text' => Array
        (
            'title' => 'Text over the image',
            'storage' => array(
                'location' => 'parameter',
            ),
            'type' => 'text',
            'widget' => 'text',
            'required' => false,
            'index_method' => 'noindex',
        ),
        'topic_image_text_link' => Array
        (
            'title' => 'Link for the text over the image',
            'storage' => array(
                'location' => 'parameter',
            ),
            'type' => 'text',
            'widget' => 'text',
            'required' => false,
            'index_method' => 'noindex',
        ),
        'topic_image_text_hide' => Array
        (
            'title' => "Hide image text (don't inherit from parent topic)",
            'storage' => array(
                'location' => 'parameter',
            ),
            'required' => false,
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '-1' => 'Show',
                    '1' => 'Hide',
                ),
                'allow_other' => false,
                'allow_multiple' => false,
            ),
            'widget' => 'select',
            'index_method' => 'noindex',
            'end_fieldset' => array(),
        ),*/
        'left_navigation_hide' => Array
        (
            'title' => "Piilota vasemman laidan navigaatio",
            'storage' => array(
                'location' => 'parameter',
            ),
            'required' => false,
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '-1' => 'Näytä',
                    '0' => 'Peri ylemmältä tasolta',
                    '1' => 'Piilota',
                ),
                'allow_other' => false,
                'allow_multiple' => false,
            ),
            'widget' => 'select',
            'end_fieldset' => array(),
        ),
        'left_content_title' => Array
        (
            'title' => 'Otsikko',
            'storage' => array(
                'location' => 'parameter',
            ),
            'type' => 'text',
            'widget' => 'text',
            'required' => false,
            'start_fieldset' => array (
                'class' => 'left_side',
                'title' => 'Vasemman laidan nosto',
            ),
        ),
        'left_content' => Array
        (
            'title' => 'Sisältö',
            'storage' => array(
                'location' => 'parameter',
            ),
            'type' => 'text',
            'type_config' => Array ( 'output_mode' => 'html' ),
            'widget' => 'tinymce',
        ),
        'left_content_hide' => Array
        (
            'title' => "Piilota vasemman laidan nosto (älä peri ylemmältä tasolta)",
            'storage' => array(
                'location' => 'parameter',
            ),
            'required' => false,
            'type' => 'select',
            'type_config' => array
            (
                'options' => array
                (
                    '-1' => 'Näytä',
                    '1' => 'Piilota',
                ),
                'allow_other' => false,
                'allow_multiple' => false,
            ),
            'widget' => 'select',
            'end_fieldset' => array(),
        ),
    ),
),