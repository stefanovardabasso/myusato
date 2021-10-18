<?php

return [
    'uri_segment' => 1,
    'sections' => [

        [
            'type' => 'header',
            'title' => "__('PLATFORM')",
            'sections' => [
                [
                    'type' => 'dropdown',
                    'title' => "__('Settings')",
                    'icon' => 'fa-gear',
                    'sections' => [
                        [
                            'type' => 'link',
                            'title' => "App\Models\Admin\User::getTitleTrans()",
                            'icon' => 'fa-user',
                            'route' => 'admin.users.index',
                            'uri_segments' => ['users'],
                            'permission_class' => \App\Models\Admin\User::class
                        ],
                        [
                            'type' => 'link',
                            'title' => "App\Models\Admin\Role::getTitleTrans()",
                            'icon' => 'fa-briefcase',
                            'route' => 'admin.roles.index',
                            'uri_segments' => ['roles'],
                            'permission_class' => \App\Models\Admin\Role::class,
                        ],
                        [
                            'type' => 'link',
                            'title' => "App\Models\Admin\Permission::getTitleTrans()",
                            'icon' => 'fa-ban',
                            'route' => 'admin.permissions.index',
                            'uri_segments' => ['permissions'],
                            'permission_class' => \App\Models\Admin\Permission::class,
                        ],
                        [
                            'type' => 'link',
                            'title' => "App\Models\Admin\Revision::getTitleTrans()",
                            'icon' => 'fa-archive',
                            'route' => 'admin.revisions.index',
                            'uri_segments' => ['revisions'],
                            'permission_class' => \App\Models\Admin\Revision::class,
                        ],
                        [
                            'type' => 'link',
                            'title' => "__('Mail setup')",
                            'icon' => 'fa-envelope',
                            'route' => 'admin.setupsmtp',
                            'uri_segments' => ['permissions'],
                            'permission_class' => \App\Models\Admin\Permission::class,
                        ]
                    ]

                ],
                [
                    'type' => 'link',
                    'title' => "__('Statistiche')",
                    'icon' => 'fa fa-bar-chart',
                    'route' => 'admin.statistics'
                ],
                [
                    'type' => 'link',
                    'title' => "__('Tutte le Sedi')",
                    'icon' => 'fa fa-map-marker',
                    'route' => 'admin.places.index'
                ],
                [
                    'type' => 'link',
                    'title' => "__('Template newsletter')",
                    'icon' => 'fa fa-code',
                    'route' => 'admin.newsl'
                ],
                [
                    'type' => 'link',
                    'title' => "__('Testi')",
                    'icon' => 'fa fa-code',
                    'route' => 'admin.blocksoftexts.index'
                ],

            ]
        ],
        [
            'type' => 'header',
            'title' => "__('PIATTAFORMA')",
            'sections' => [
                [
                    'type' => 'link',
                    'title' => "__('Prodotti')",
                    'icon' => 'fa fa-cloud-download',
                    'route' => 'admin.products.index',
                ],
                [
                    'type' => 'link',
                    'title' => "__('Offerte Bundle')",
                    'icon' => 'fa fa-cloud-download',
                    'route' => 'admin.offerts.index',
                ],
                [
                    'type' => 'dropdown',
                    'title' => "__('Richieste')",
                    'icon' => 'fa fa-question',
                    'sections' => [
                        [
                            'type' => 'link',
                            'title' => "__('Piu info')",
                            'icon' => 'fa fa-question',
                            'route' => 'admin.moreinfos.index'
                        ],
                        [
                            'type' => 'link',
                            'title' => "__('QuotazionI')",
                            'icon' => 'fa fa-question',
                            'route' => 'admin.quotations.index'
                        ],
                        [
                            'type' => 'link',
                            'title' => "__('Opzioni')",
                            'icon' => 'fa fa-question',
                            'route' => 'admin.options.index'
                        ],

                    ],
                ],
//                [
//                    'type' => 'link',
//                    'title' => "__('CMS')",
//                    'icon' => 'fa fa-file-text',
//                    'route' => 'admin.cmss.index',
//                ],
                [
                    'type' => 'link',
                    'title' => "__('Contact Form')",
                    'icon' => 'fa fa-id-card-o',
                    'route' => 'admin.contactforms.index',
                ],
                [
                    'type' => 'link',
                    'title' => "__('VTU')",
                    'icon' => 'fa fa-id-card-o',
                    'route' => 'admin.vtus.index',
                ],
                [
                    'type' => 'link',
                    'title' => "__('Ricerche salvate')",
                    'icon' => 'fa fa-search',
                    'route' => 'admin.savedfilters.index',
                ],
                [
                    'type' => 'dropdown',
                    'title' => "__('Utenti')",
                    'icon' => 'fa-users',
                    'sections' => [
                        [
                            'type' => 'link',
                            'title' => "__('Amministratori')",
                            'icon' => 'fa fa-users',
                            'route' => 'admin.musers.amministratori'
                        ],
                        [
                            'type' => 'link',
                            'title' => "__('Assistenza backoffice')",
                            'icon' => 'fa fa-users',
                            'route' => 'admin.musers.amministratorib'
                        ],
                        [
                            'type' => 'link',
                            'title' => "__('Venditori')",
                            'icon' => 'fa fa-users',
                            'route' => 'admin.musers.venditori'
                        ],
                        [
                            'type' => 'link',
                            'title' => "__('Venditori avanzati')",
                            'icon' => 'fa fa-users',
                            'route' => 'admin.musers.venditoriav'
                        ],
                        [
                            'type' => 'link',
                            'title' => "__('Commercianti')",
                            'icon' => 'fa fa-users',
                            'route' => 'admin.musers.commercianti'
                        ],
                        [
                            'type' => 'link',
                            'title' => "__('Clienti finali')",
                            'icon' => 'fa fa-users',
                            'route' => 'admin.musers.clientif'
                        ],

                    ],
                ],
            ]
        ],
//        [
//            'type' => 'header',
//            'title' => "__('Siti esteri')",
//            'sections' => [
//                [
//                    'type' => 'link',
//                    'title' => "__('Tuttocarrellielevatori')",
//                    'icon' => 'glyphicon glyphicon-globe',
//                    'route' => 'admin.tuttocarrellis.index'
//                ],
//                [
//                    'type' => 'link',
//                    'title' => "__('Mascus')",
//                    'icon' => 'glyphicon glyphicon-globe',
//                    'route' => 'admin.macus.index'
//                ],
//                [
//                    'type' => 'link',
//                    'title' => "__('Supralift')",
//                    'icon' => 'glyphicon glyphicon-globe',
//                    'route' => 'admin.suprlifts.index'
//                ],
//
//            ]
//        ],
        [
            'type' => 'header',
            'title' => "__('ACCOUNT')",
            'sections' => [
                [
                    'type' => 'link',
                    'title' => "__('Profile')",
                    'icon' => 'fa-user-circle-o',
                    'route' => 'admin.profile.edit',
                    'uri_segments' => ['profile'],
                ],



                [
                    'type' => 'link',
                    'title' => "App\Models\Admin\Report::getTitleTrans()",
                    'icon' => 'fa-download',
                    'route' => 'admin.reports.index',
                    'uri_segments' => ['reports'],
                    'permission_class' => \App\Models\Admin\Report::class,
                ]
            ]
        ],

        [
            'type' => 'link',
            'title' => "__('Logout')",
            'icon' => 'fa-arrow-left',
            'route' => 'logout'
        ]
    ]
];
