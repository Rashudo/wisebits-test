<?php

return [
    /*
     *  Automatic registration of routes will only happen if this setting is `true`
     */
    'enabled' => true,

    /*
     * Controllers in these directories that have routing attributes
     * will automatically be registered.
     *
     * Optionally, you can specify group configuration by using key/values
     */
    'directories' => [
        base_path('app/Containers') => [
            'patterns' => ['*Controller.php'],
            'not_patterns' => ['*Test'],
        ],
        /*
            app_path('Http/Controllers'),
        */
        /*
        app_path('Http/Controllers/Api') => [
           'prefix' => 'api',
           'middleware' => 'api',
            // only register routes in files that match the patterns
           'patterns' => ['*Controller.php'],
           // do not register routes in files that match the patterns
           'not_patterns => [],
        ],
        */
    ],

    /**
     * This middleware will be applied to all routes.
     */
    'middleware' => []
];
