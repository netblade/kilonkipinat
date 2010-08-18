'default' => array
(
    'description' => 'account',
    'fields'      => array
    (
        'firstname' => Array
        (
            'title' => 'Etunimi',
            'storage' => 'firstname',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'lastname' => Array
        (
            'title' => 'Sukunimi',
            'storage' => 'lastname',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'nickname' => Array
        (
            'title' => 'Kutsumanimi',
            'storage' => 'nickname',
            'type' => 'text',
            'widget' => 'text',
        ),
        'email' => Array
        (
            'title' => 'Sähköposti',
            'storage' => 'email',
            'type' => 'text',
            'widget' => 'text',
        ),
        'handphone' => Array
        (
            'title' => 'Puhelinnumero',
            'storage' => 'handphone',
            'type' => 'text',
            'widget' => 'text',
        ),
        'street' => Array
        (
            'title' => 'Katuosoite',
            'storage' => 'street',
            'type' => 'text',
            'widget' => 'text',
        ),
        'postcode' => Array
        (
            'title' => 'Postinumero',
            'storage' => 'postcode',
            'type' => 'text',
            'widget' => 'text',
        ),
        'city' => Array
        (
            'title' => 'Postitoimipaikka',
            'storage' => 'city',
            'type' => 'text',
            'widget' => 'text',
        ),
        'description' => Array
        (
            'title' => 'Kuvaus',
            'storage' => 'extra',
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html'
            ),
            'widget' => 'tinymce',
        ),
        'birthdate' => Array
        (
            'title' => 'Syntymäpäivä',
            'storage' => 'birthdate',
            'type' => 'date',
            'widget_config' => array
            (
                'show_time' => false,
            ),
            'widget' => 'jsdate',
        ),
        'imJabber' => Array
        (
            'title' => 'GTalk',
            'storage' => 'imJabber',
            'type' => 'text',
            'widget' => 'text',
        ),
        'imMsn' => Array
        (
            'title' => 'Microsoft messenger',
            'storage' => 'imMsn',
            'type' => 'text',
            'widget' => 'text',
        ),
        'imIcq' => Array
        (
            'title' => 'Icq',
            'storage' => 'imIrcGalleria',
            'type' => 'text',
            'widget' => 'text',
        ),
        'imSkype' => Array
        (
            'title' => 'Skype',
            'storage' => 'imSkype',
            'type' => 'text',
            'widget' => 'text',
        ),
        'imIrcGalleria' => Array
        (
            'title' => 'Irc-Galleria nick',
            'storage' => 'imIrcGalleria',
            'type' => 'text',
            'widget' => 'text',
        ),
        'imFacebook' => Array
        (
            'title' => 'Facebook-profiilin url',
            'storage' => 'imFacebook',
            'type' => 'text',
            'widget' => 'text',
        ),
        'bankAccountNumber' => Array
        (
            'title' => 'Tilinumero',
            'storage' => 'bankAccountNumber',
            'type' => 'text',
            'widget' => 'text',
        ),
        'bankAccountBank' => Array
        (
            'title' => 'Pankki',
            'storage' => 'bankAccountBank',
            'type' => 'text',
            'widget' => 'text',
        ),
        'bankRefNum' => Array
        (
            'title' => 'Viitenumero',
            'storage' => 'bankRefNum',
            'type' => 'text',
            'widget' => 'text',
        ),
    ),
),

