'default' => array
(
    'description' => 'Kulukorvauslomake, lippukunta',
    'fields'      => array
    (
        'title' => Array
        (
            'title' => 'Otsikko',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'event' => Array
        (
            'title' => 'Tapahtuma',
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
        'reportType' => Array
        (
            'title' => 'Tilityksen tyyppi',
            'storage' => 'reportType',
            'type' => 'select',
            'type_config' => array
            (
                'require_corresponding_option' => false,
                'options' => array(
                    10 => 'Maksetaan saajan tilille', 
                    20 => 'Maksettu lpk:n kortilla',
                    30 => 'Ennakon selvitys',
                    40 => 'Ennakko / käteisnosto'
                ),
                'allow_other' => false,
                'allow_multiple' => false,
            ),
            'widget' => 'select',
        ),
        'person' => Array
        (
            'title' => 'Tilityksen antaja / saaja',
            'storage' => 'person',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'reporter' => Array
        (
            'title' => 'Raportoija, mikäli eri henkilö',
            'storage' => 'reporter',
            'type' => 'text',
            'widget' => 'text',
        ),
        'accountNumber' => Array
        (
            'title' => 'Tilinumero',
            'storage' => 'accountNumber',
            'type' => 'text',
            'widget' => 'text',
        ),
        'place' => Array
        (
            'title' => 'Paikka',
            'storage' => 'place',
            'type' => 'text',
            'widget' => 'text',
        ),
        'date' => Array
        (
            'title' => 'Päivämäärä',
            'storage' => 'date',
            'type' => 'date',
            'widget' => 'jsdate',
            'widget_config' => array(
                'show_time' => false,
            ),
        ),
    ),
),

