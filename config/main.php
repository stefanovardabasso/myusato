<?php

return [
    'app' => [
        'credits' => env('APP_CREDITS'),
        'version' => '1.0'
    ],

    'repo_path' => env('REPO_PATH', null),

    /**
     * Languages used for translations
     */
    'available_languages' => [
        'en' => 'English',
        'bg' => 'Bulgarian',
        'it' => 'Italian',
    ],

    /**
     * Time intervals for user activity status
     * Used in User.php for calculated "activity_status" attribute
     */
    'activity_status_time_intervals' => [
        'offline' => env('ACTIVITY_STATUS_OFFLINE_INTERVAL', 15),
        'inactive' => env('ACTIVITY_STATUS_INACTIVE_INTERVAL', 7),
    ],

    'help_roles' => [
        'Help',
    ],

    'dashboard' => [
        'widgets' => [
            'sortable-1' => [
            ],
            'sortable-2' => [
                [
                    'id' => 'widgets.calendar',
                    'expanded' => 1,
                ],
            ],
            'sortable-3' => [

            ],
        ]
    ],

    'emails' => [
        'no_replay' => env('MAIL_NO_REPLAY', 'noreplay@admin-panel.com'),
        'mail_system_messages' => explode(',', env('MAIL_SYSTEM_MESSAGES', 'simeon.ivaylov.petrov@gmail.com')),
    ],

    'users' => [
        'admin' => [
            'name' => env('ADMIN_NAME', 'ADMIN'),
            'surname' => env('ADMIN_SURNAME', 'ADMIN'),
            'email' => env('ADMIN_EMAIL', 'admin@admin.com'),
            'password' => env('ADMIN_PASSWORD', '123456'),
        ]
    ],
    'sap_host'  => env('SAP_HOST'),
    'sap_sysnr'  => env('SAP_SYSNR'),
    'sap_client'  => env('SAP_CLIENT'),
    'sap_user'  => env('SAP_USER'),
    'sap_pass'  => env('SAP_PASS'),

    'date_of_online' => '08/01/2021',

];
