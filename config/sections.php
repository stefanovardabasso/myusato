<?php

return [
    [
        'label' => "__('Settings')",
        'children' => [
            [
                'label' => "__('Users')",
                'permission_target' => 'users',
                'permissions' => [
                    'create' => "__('create-permission')",
                    'view_all' => "__('view_all-permission')",
                    'view_own' => "__('view_own-permission')",
                    'update_all' => "__('update_all-permission')",
                    'update_own' => "__('update_own-permission')",
                    'delete_all' => "__('delete_all-permission')",
                    'delete_own' => "__('delete_own-permission')",
                    'view_sensitive_data' => "__('view_sensitive_data-permission')",
                    'update_sensitive_data' => "__('update_sensitive_data-permission')",
                    'export' => "__('export-permission')",
                ]
            ],
            [
                'label' => "__('Roles')",
                'permission_target' => 'roles',
                'permissions' => [
                    'create' => "__('create-permission')",
                    'view_all' => "__('view_all-permission')",
                    'view_own' => "__('view_own-permission')",
                    'update_all' => "__('update_all-permission')",
                    'update_own' => "__('update_own-permission')",
                    'delete_all' => "__('delete_all-permission')",
                    'delete_own' => "__('delete_own-permission')",
                    'export' => "__('export-permission')",
                ]
            ],
        ],
    ],
    [
        'label' => "__('FAQ')",
        'children' => [
            [
                'label' => "__('Categories')",
                'permission_target' => 'faq_categories',
                'permissions' => [
                    'create' => "__('create-permission')",
                    'view_all' => "__('view_all-permission')",
                    'view_own' => "__('view_own-permission')",
                    'update_all' => "__('update_all-permission')",
                    'update_own' => "__('update_own-permission')",
                    'delete_all' => "__('delete_all-permission')",
                    'delete_own' => "__('delete_own-permission')",
                    'export' => "__('export-permission')",
                ]
            ],
            [
                'label' => "__('Questions')",
                'permission_target' => 'faq_questions',
                'permissions' => [
                    'create' => "__('create-permission')",
                    'view_all' => "__('view_all-permission')",
                    'view_own' => "__('view_own-permission')",
                    'update_all' => "__('update_all-permission')",
                    'update_own' => "__('update_own-permission')",
                    'delete_all' => "__('delete_all-permission')",
                    'delete_own' => "__('delete_own-permission')",
                    'export' => "__('export-permission')",
                ]
            ],
        ],
    ],
    [
        'label' => "__('Messages')",
        'permission_target' => 'messages',
        'permissions' => [
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'create_direct' => "__('create_direct-permission')",
            'create_help' => "__('create_help-permission')",
        ]
    ],
    [
        'label' => "__('Notifications')",
        'permission_target' => 'notifications',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Calendar')",
        'permission_target' => 'events',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Reports')",
        'permission_target' => 'reports',
        'permissions' => [
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'download_all' => "__('download_all-permission')",
            'download_own' => "__('download_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
        ]
    ],
    /* crud:create add section */
    [
        'label' => "__('Vendorbadges')",
        'permission_target' => 'vendorbadges',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Tuttocarrellis')",
        'permission_target' => 'tuttocarrellis',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Suprlifts')",
        'permission_target' => 'suprlifts',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Macus')",
        'permission_target' => 'macus',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Places')",
        'permission_target' => 'places',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Vendorplaces')",
        'permission_target' => 'vendorplaces',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Components')",
        'permission_target' => 'components',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Galrtcs')",
        'permission_target' => 'galrtcs',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Quotationvens_lines')",
        'permission_target' => 'quotationvens_lines',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Quotationvens')",
        'permission_target' => 'quotationvens',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Savedfilters_lines')",
        'permission_target' => 'savedfilters_lines',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Savedfilters')",
        'permission_target' => 'savedfilters',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Options')",
        'permission_target' => 'options',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Moreinfos')",
        'permission_target' => 'moreinfos',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Quotation_lines')",
        'permission_target' => 'quotation_lines',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Quotations')",
        'permission_target' => 'quotations',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Mymachines')",
        'permission_target' => 'mymachines',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Vtus')",
        'permission_target' => 'vtus',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Caracts')",
        'permission_target' => 'caracts',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Questions_filters_traductions')",
        'permission_target' => 'questions_filters_traductions',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Questions_filters')",
        'permission_target' => 'questions_filters',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Fam_selects')",
        'permission_target' => 'fam_selects',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Buttons_filters')",
        'permission_target' => 'buttons_filters',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Cmss')",
        'permission_target' => 'cmss',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Contactforms')",
        'permission_target' => 'contactforms',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Gallerys')",
        'permission_target' => 'gallerys',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Products_lines')",
        'permission_target' => 'products_lines',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Questions_saps')",
        'permission_target' => 'questions_saps',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Productlines')",
        'permission_target' => 'productlines',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Saps')",
        'permission_target' => 'saps',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Offerts')",
        'permission_target' => 'offerts',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
    [
        'label' => "__('Products')",
        'permission_target' => 'products',
        'permissions' => [
            'create' => "__('create-permission')",
            'view_all' => "__('view_all-permission')",
            'view_own' => "__('view_own-permission')",
            'update_all' => "__('update_all-permission')",
            'update_own' => "__('update_own-permission')",
            'delete_all' => "__('delete_all-permission')",
            'delete_own' => "__('delete_own-permission')",
            'export' => "__('export-permission')",
        ]
    ],
];
