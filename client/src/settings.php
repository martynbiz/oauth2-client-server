<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],

        'client_id' => 'japantravel',
        'client_secret' => 'qwertyuiop1234567890',

        'urls' => [
            'token' => 'http://sso.jt.martyndev/oauth/token',
            'authorize' => 'http://sso.jt.martyndev/oauth/authorize',
            'authorize_redirect_uri' => 'localhost:8080/authorize',
            'resource' => 'http://api2.jt.martyndev/articles',
        ],

        // 'resource_params' => {},
        // 'user_credentials' => [
        //     'japantravel',
        //     'qwertyuiop1234567890'
        // ],
        // 'http_options' => { 'exceptions': false }
    ],
];
