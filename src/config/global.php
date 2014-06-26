<?php

return 
[
    ///////////////////////////////////////////////////////////////////////////

    'global'        =>
    [
        'database'          =>
        [
            'server'                => '127.0.0.1',
            'port'                  => '5432',
            'db'                    => 'seo',
            'user'                  => 'seo',
            'passwd'                => '2c8UCLa2VCgQmkFzzAemqVtP3FnJcL89',
        ],

        'domains'           =>
            [
                'www'           => 'seo.dev.artwebua.com.ua/',
            ],
    ],



    ///////////////////////////////////////////////////////////////////////////

    'frontend'                           =>
    [
        'dirs'              =>
        [
            'controllersDir'            => 'app/frontend/controllers/',
            'appLibrariesDir'           => 'app/frontend/lib/',
            'librariesDir'              => 'lib/',
            'modelsDir'                 => 'lib/models/',
            'viewsDir'                  => 'app/frontend/views/',
            'messagesDir'               => 'app/frontend/messages/',
        ],

        'defaults'          =>
        [
            'default_route'             => 'homepage',
        ],

    ],

    ///////////////////////////////////////////////////////////////////////////

    'backend'                           =>
    [
        'dirs'              =>
        [
            'controllersDir'            => 'app/backend/controllers/',
            'appLibrariesDir'           => 'app/backend/lib/',
            'librariesDir'              => 'lib/',
            'modelsDir'                 => 'lib/models/',
            'viewsDir'                  => 'app/backend/views/',
            'messagesDir'               => 'app/backend/messages/',
        ],


    ],

    ///////////////////////////////////////////////////////////////////////////

    'tasks'                             =>
    [
        'dirs'                          =>
        [
            'controllersDir'            => 'app/tasks/',
            'librariesDir'              => 'lib/',
            'modelsDir'                 => 'lib/models/',
        ],
    ],

    ///////////////////////////////////////////////////////////////////////////
];
