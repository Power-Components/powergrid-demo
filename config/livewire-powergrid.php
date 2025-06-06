<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    |
    | PowerGrid supports Tailwind and Bootstrap 5 themes.
    | Configure here the theme of your choice.
    */

    'theme' => \PowerComponents\LivewirePowerGrid\Themes\DaisyUI::class,
    // 'theme' => \PowerComponents\LivewirePowerGrid\Themes\Bootstrap5::class,

    'icon_resources' => [
        'paths' => [

            'default' => 'resources/views/components/icons',
            // 1.x
            //  'vendor/wireui/wireui/resources/views/components/icons/outline',
            //  'vendor/wireui/wireui/resources/views/components/icons/solid',
            // 2.x
            //
            //  'mini'    => 'vendor/wireui/heroicons/src/views/components/mini',
            //  'outline' => 'vendor/wireui/heroicons/src/views/components/outline',
            //  'solid'   => 'vendor/wireui/heroicons/src/views/components/solid',
        ],

        'allowed' => [
            // 'pencil','eye'
        ],

        'attributes' => ['class' => 'w-5 text-red-600'],
    ],
    /*
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    |
    | Plugins used: flatpickr.js to datepicker.
    |
    */

    'plugins' => [
        /*
         * https://flatpickr.js.org
         */
        'flatpickr' => [
            'locales' => [
                'pt_BR' => [
                    'locale'     => 'pt',
                    'dateFormat' => 'd/m/Y H:i',
                    'enableTime' => true,
                    'time_24hr'  => true,
                ],
            ],
        ],

        'select' => [
            'default' => 'tom',

            /*
             * TomSelect Options
             * https://tom-select.js.org
             */
            'tom' => [
                'plugins' => [
                    'clear_button' => [
                        'title' => 'Remove all selected options',
                    ],
                ],
            ],

            /*
             * Slim Select options
             * https://slimselectjs.com/
             */
            'slim' => [
                'settings' => [
                    'alwaysOpen' => false,
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    |
    | PowerGrid supports inline and outside filters.
    | 'inline': Filters data inside the table.
    | 'outside': Filters data outside the table.
    | 'null'
    |
    */

    'filter' => 'inline',

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Cache is enabled by default to improve search performance when using collections.
    | When enabled, data is reloaded whenever the page is refreshed or a field is updated.
    |
    */

    'cached_data' => true,

    /*
    |--------------------------------------------------------------------------
    | New Release Notification
    |--------------------------------------------------------------------------
    |
    | PowerGrid can verify if a new release is available when you create a new PowerGrid Table.
    |
    | This feature depends on composer/composer.
    | To install, run: `composer require composer/composer --dev`
    |
    */

    'check_version' => false,

    /*
    |--------------------------------------------------------------------------
    | Exportable class
    |--------------------------------------------------------------------------
    |
    |
    */

    'exportable' => [
        'default'      => 'openspout_v4',
        'openspout_v4' => [
            'xlsx' => \PowerComponents\LivewirePowerGrid\Components\Exports\OpenSpout\v4\ExportToXLS::class,
            'csv'  => \PowerComponents\LivewirePowerGrid\Components\Exports\OpenSpout\v4\ExportToCsv::class,
        ],
        'openspout_v3' => [
            'xlsx' => \PowerComponents\LivewirePowerGrid\Components\Exports\OpenSpout\v3\ExportToXLS::class,
            'csv'  => \PowerComponents\LivewirePowerGrid\Components\Exports\OpenSpout\v3\ExportToCsv::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-Discover Models
    |--------------------------------------------------------------------------
    |
    | PowerGrid will search for Models in the directories listed below.
    | These Models be listed as options when you run the
    | "artisan powergrid:create" command.
    |
    */

    'auto_discover_models_paths' => [
        app_path('Models'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-Inject Assets
    |--------------------------------------------------------------------------
    |
    | PowerGrid will automatically inject assets if set to "true"
    |
    */

    'auto_inject_assets' => true,
];
