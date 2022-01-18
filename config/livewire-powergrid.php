<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Template
    |--------------------------------------------------------------------------
    |
    | You will be able to know which theme pattern will be loaded
    | bootstrap or tailwind
    |
    */
    'theme' => 'bootstrap',

    /*
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    |
    | Plugins used: bootstrap-select when bootstrap, flatpicker.js to datepicker
    |
    */
    'plugins' => [
        /*
         * https://github.com/snapappointments/bootstrap-select
         */
        'bootstrap-select' => [
            'js'  => null,
            'css' => null
        ],
        /*
         * https://flatpickr.js.org
         */
        'flat_piker' => [
            'js'        => null,
            'css'       => null,
            'translate' => null,
            'locales'   => [
                'pt_BR' => [
                    'locale'     => 'pt',
                    'dateFormat' => 'd/m/Y H:i',
                    'enableTime' => true,
                    'time_24hr'  => true
                ]
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    |
    | You choose which type of filter you want to use inline
    | to filter inside the table or outside the table
    | 'inline' or 'outside'
    |
    */

    'filter' => 'inline',

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | When the data is cached, the search is much faster.
    | It is updated whenever the page is reloaded or a field is changed
    |
    */
    'cached_data' => true,

    /*
    |--------------------------------------------------------------------------
    | AlpineJS CDN
    |--------------------------------------------------------------------------
    |
    | Define here the CDN source for imported AlpineJS
    |
    */

    'alpinejs_cdn' => null,

     /*
    |--------------------------------------------------------------------------
    | Notification latest version
    |--------------------------------------------------------------------------
    |
    | Add the package: `composer require composer/composer --dev` to your project.
    | and change this value to `true`
    |
    */
    'check_version' => true
];
