'retki' => array
(
    'description' => 'retki',
    'fields'      => array
    (
        'name' => Array
        (
            'title' => 'url name',
            'storage' => 'name',
            'type' => 'urlname',
            'widget' => 'text',
        ),
        'title' => Array
        (
            'title' => 'title',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'type' => Array
        (
            'title' => 'type',
            'storage' => 'type',
            'required' => true,
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array
            (
                'allow_multiple' => false,
                'allow_other' => false,
                'options' => array
                (
                    FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GENERIC => 'Yleinen',
                    FI_KILONKIPINAT_EVENTS_EVENT_TYPE_TRIP => 'Retki',
                    FI_KILONKIPINAT_EVENTS_EVENT_TYPE_CAMP => 'Leiri',
                    FI_KILONKIPINAT_EVENTS_EVENT_TYPE_COURSE => 'Kurssi',
                    FI_KILONKIPINAT_EVENTS_EVENT_TYPE_CONTEST => 'Kilpailu',
                    FI_KILONKIPINAT_EVENTS_EVENT_TYPE_EXAM => 'Loppukoe',
                    FI_KILONKIPINAT_EVENTS_EVENT_TYPE_HIKE => 'Vaellus',
                )
            ),
        ),
        'start' => array
        (
            // COMPONENT-REQUIRED
            'title' => 'start',
            'storage' => 'start',
            'type' => 'date',
            'type_config' => array
            (
                'storage_type' => 'ISO'
            ),
            'widget' => 'jsdate',
            'widget_config' => array
            (
                'hide_seconds' => true,
            ),
        ),
        'end' => array
        (
            // COMPONENT-REQUIRED
            'title' => 'end',
            'storage' => 'end',
            'type' => 'date',
            'type_config' => array
            (
                'storage_type' => 'ISO',
                'earlier_field' => 'start',
            ),
            'widget' => 'jsdate',
            'widget_config' => array
            (
                'hide_seconds' => true,
            ),
        ),
        'content' => Array
        (
            'title' => 'content',
            'storage' => 'content',
            'required' => true,
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html'
            ),
            'widget' => 'tinymce',
        ),
    ),
),


'kokous' => array
(
    'description' => 'kokous',
    'fields'      => array
    (
        'name' => Array
        (
            'title' => 'url name',
            'storage' => 'name',
            'type' => 'urlname',
            'widget' => 'text',
        ),
        'title' => Array
        (
            'title' => 'title',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'type' => Array
        (
            'title' => 'type',
            'storage' => 'type',
            'required' => true,
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array
            (
                'allow_multiple' => false,
                'allow_other' => false,
                'options' => array
                (
                    FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_GENERIC => 'Yleinen',
                    FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_JN => 'JohtajaNeuvosto',
                    FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_LH => 'Laajennettu hallitus',
                    FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_BOARD => 'Hallitus',
                    FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_ANNUAL => 'Vuosikokous',
                )
            ),
        ),
        'start' => array
        (
            // COMPONENT-REQUIRED
            'title' => 'start',
            'storage' => 'start',
            'type' => 'date',
            'type_config' => array
            (
                'storage_type' => 'ISO'
            ),
            'widget' => 'jsdate',
            'widget_config' => array
            (
                'hide_seconds' => true,
            ),
        ),
        'end' => array
        (
            // COMPONENT-REQUIRED
            'title' => 'end',
            'storage' => 'end',
            'type' => 'date',
            'type_config' => array
            (
                'storage_type' => 'ISO',
                'earlier_field' => 'start',
            ),
            'widget' => 'jsdate',
            'widget_config' => array
            (
                'hide_seconds' => true,
            ),
        ),
        'content' => Array
        (
            'title' => 'content',
            'storage' => 'content',
            'required' => true,
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html'
            ),
            'widget' => 'tinymce',
        ),
    ),
),