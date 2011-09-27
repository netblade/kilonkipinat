'retki' => array
(
    'description' => 'Tapahtuma',
    'fields'      => array
    (
        'title' => Array
        (
            'title' => 'Tapahtuman nimi',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
            'start_fieldset' => array
            (
                'title' => 'Perustiedot',
            ),
        ),
        'type' => Array
        (
            'title' => 'Tyyppi',
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
        'visibility' => Array
        (
            'title' => 'Näkyvyys',
            'storage' => 'visibility',
            'required' => true,
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array
            (
                'allow_multiple' => false,
                'allow_other' => false,
                'options' => array
                (
                    FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_PUBLIC => 'Näkyy kaikille',
                    FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_SECURE => 'Näkyy vain käyttäjille',
                ),
            ),
        ),
        'kisa' => Array
        (
            'title' => 'KiSa',
            'storage' => 'kisa',
            'required' => true,
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array
            (
                'allow_multiple' => false,
                'allow_other' => false,
                'options' => array
                (
                    FI_KILONKIPINAT_EVENTS_EVENT_KISA_FALSE => 'Ei',
                    FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH => 'Sekä että',
                    FI_KILONKIPINAT_EVENTS_EVENT_KISA_TRUE => 'Vain KiSa',
                ),
            ),
        ),
        'start' => array
        (
            'title' => 'Alkaa',
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
            'title' => 'Loppuu',
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
        'allday' => array
        (
            'title' => 'Koko päivän tapahtuma (ei näytetä kellonaikoja)',
            'storage' => 'allday',
            'type' => 'boolean',
            'widget' => 'checkbox',
        ),
        'hideendtime' => array
        (
            'title' => 'Piiloita loppumisaika',
            'storage' => 'hideendtime',
            'type' => 'boolean',
            'widget' => 'checkbox',
            'end_fieldset' => 1,
        ),
        'content' => Array
        (
            'title' => 'Kuvaus (julkinen)',
            'storage' => 'content',
            'required' => true,
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html'
            ),
            'widget' => 'tinymce',
            'start_fieldset' => array
            (
                'title' => 'Kuvaus',
            ),
        ),
        'contentprivate' => Array
        (
            'title' => 'Sisältö (näkyy vain käyttäjille)',
            'storage' => 'contentprivate',
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html'
            ),
            'widget' => 'tinymce',
        ),
        'url' => Array
        (
            'title' => 'URL',
            'storage' => 'url',
            'type' => 'text',
            'widget' => 'text',
            'end_fieldset' => 1,
        ),
        'eventslocation' => array
        (
            'title' => 'Tallennettu paikka',
            'storage' => 'eventslocation',
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
                'class'       => 'fi_kilonkipinat_events_location_dba',
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
                ),
                'orders' => array
                (
                    array
                    (
                        'title' => 'ASC',
                    ),
                ),
            ),
            'start_fieldset' => array
            (
                'title' => 'Paikkatiedot',
            ),
        ),
        'location' => array
        (
            'title' => 'Tarkka paikka',
            'storage' => 'location',
            'type' => 'position',
            'widget' => 'position',
            'widget_config' => Array
            (
                'service' => 'yahoo', //Possible values are city, geonames, yahoo
            ),
        ),
        'locationzoom' => Array
        (
            'title' => 'Kartan zoom',
            'storage' => 'locationzoom',
            'required' => true,
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array
            (
                'allow_multiple' => false,
                'allow_other' => false,
                'options' => array
                (
                    10 => '10',
                    11 => '11',
                    12 => '12',
                    13 => '13 (about 10 kilsaa)',
                    14 => '14',
                    15 => '15 (about kilsa)',
                    16 => '16',
                    17 => '17',
                ),
            ),
        ),
        'locationvisibility' => Array
        (
            'title' => 'Paikkatiedon näkyvyys',
            'storage' => 'locationvisibility',
            'required' => true,
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array
            (
                'allow_multiple' => false,
                'allow_other' => false,
                'options' => array
                (
                    FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_PUBLIC => 'Näkyy kaikille',
                    FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_TEXT_PUBLIC => 'Vain lisäteksti näkyy',
                    FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_SECURE => 'Näkyy vain käyttäjille',
                ),
            ),
        ),
        'locationtext' => Array
        (
            'title' => 'Paikka tekstinä',
            'storage' => 'locationtext',
            'type' => 'text',
            'widget' => 'textarea',
            'end_fieldset' => 1,
        ),
        'downloads' => array
        (
            'title' => 'Tiedostot',
            'storage' => null,
            'type' => 'blobs',
            'type_config' => array(
                'sortable' => true,
            ),
            'widget' => 'downloads',
        ),
    ),
),


'kokous' => array
(
    'description' => 'Kokous',
    'fields'      => array
    (
        'title' => Array
        (
            'title' => 'Kokouksen nimi',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
            'start_fieldset' => array
            (
                'title' => 'Perustiedot',
            ),
        ),
        'type' => Array
        (
            'title' => 'Tyyppi',
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
        'visibility' => Array
        (
            'title' => 'Näkyvyys',
            'storage' => 'visibility',
            'required' => true,
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array
            (
                'allow_multiple' => false,
                'allow_other' => false,
                'options' => array
                (
                    FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_PUBLIC => 'Näkyy kaikille',
                    FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_SECURE => 'Näkyy vain käyttäjille',
                ),
            ),
        ),
        'kisa' => Array
        (
            'title' => 'KiSa',
            'storage' => 'kisa',
            'required' => true,
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array
            (
                'allow_multiple' => false,
                'allow_other' => false,
                'options' => array
                (
                    FI_KILONKIPINAT_EVENTS_EVENT_KISA_FALSE => 'Ei',
                    FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH => 'Sekä että',
                    FI_KILONKIPINAT_EVENTS_EVENT_KISA_TRUE => 'Vain KiSa',
                ),
            ),
        ),
        'start' => array
        (
            'title' => 'Alkaa',
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
            'title' => 'Loppuu',
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
        'allday' => array
        (
            'title' => 'Koko päivän tapahtuma (ei näytetä kellonaikoja)',
            'storage' => 'allday',
            'type' => 'boolean',
            'widget' => 'checkbox',
        ),
        'hideendtime' => array
        (
            'title' => 'Piiloita loppumisaika',
            'storage' => 'hideendtime',
            'type' => 'boolean',
            'widget' => 'checkbox',
            'end_fieldset' => 1,
        ),
        'content' => Array
        (
            'title' => 'Sisältö (julkinen)',
            'storage' => 'content',
            'required' => true,
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html'
            ),
            'widget' => 'tinymce',
            'start_fieldset' => array
            (
                'title' => 'Kuvaus',
            ),
        ),
        'contentprivate' => Array
        (
            'title' => 'Sisältö (näkyy vain käyttäjille)',
            'storage' => 'contentprivate',
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html'
            ),
            'widget' => 'tinymce',
        ),
        'url' => Array
        (
            'title' => 'URL',
            'storage' => 'url',
            'type' => 'text',
            'widget' => 'text',
            'end_fieldset' => 1,
        ),
        'eventslocation' => array
        (
            'title' => 'Tallennettu paikka',
            'storage' => 'eventslocation',
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
                'class'       => 'fi_kilonkipinat_events_location_dba',
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
                ),
                'orders' => array
                (
                    array
                    (
                        'title' => 'ASC',
                    ),
                ),
            ),
            'start_fieldset' => array
            (
                'title' => 'Paikkatiedot',
            ),
        ),
        'location' => array
        (
            'title' => 'Tarkka paikka',
            'storage' => 'location',
            'type' => 'position',
            'widget' => 'position',
            'widget_config' => Array
            (
                'service' => 'yahoo', //Possible values are city, geonames, yahoo
            ),

        ),
        'locationzoom' => Array
        (
            'title' => 'Kartan zoom',
            'storage' => 'locationzoom',
            'required' => true,
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array
            (
                'allow_multiple' => false,
                'allow_other' => false,
                'options' => array
                (
                    10 => '10',
                    11 => '11',
                    12 => '12',
                    13 => '13 (about 10 kilsaa)',
                    14 => '14',
                    15 => '15 (about kilsa)',
                    16 => '16',
                    17 => '17',
                ),
            ),
        ),
        'locationvisibility' => Array
        (
            'title' => 'Paikkatiedon näkyvyys',
            'storage' => 'locationvisibility',
            'required' => true,
            'type' => 'select',
            'widget' => 'select',
            'type_config' => array
            (
                'allow_multiple' => false,
                'allow_other' => false,
                'options' => array
                (
                    FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_PUBLIC => 'Näkyy kaikille',
                    FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_TEXT_PUBLIC => 'Vain lisäteksti näkyy',
                    FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_SECURE => 'Näkyy vain käyttäjille',
                ),
            ),
        ),
        'locationtext' => Array
        (
            'title' => 'Paikka tekstinä',
            'storage' => 'locationtext',
            'type' => 'text',
            'widget' => 'textarea',
            'end_fieldset' => 1,
        ),
        'downloads' => array
        (
            'title' => 'Tiedostot',
            'storage' => null,
            'type' => 'blobs',
            'type_config' => array(
                'sortable' => true,
            ),
            'widget' => 'downloads',
        ),
        'esityslista' => array
        (
            'title' => 'Esityslistat',
            'storage' => null,
            'type' => 'blobs',
            'type_config' => array(
                'sortable' => true,
            ),
            'widget' => 'downloads',
        ),
        'poytakirja' => array
        (
            'title' => 'Pöytäkirjat (näkyy vain käyttäjille)',
            'storage' => null,
            'type' => 'blobs',
            'type_config' => array(
                'sortable' => true,
            ),
            'widget' => 'downloads',
        ),
    ),
),