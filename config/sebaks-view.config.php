<?php

return [
    'layouts' => [
        'admin-layout' => [
            'template' => 't4web-admin/layout/layout',
            'children' => [
                't4web-admin-top-panel',
                't4web-admin-sidebar-menu',
            ],
        ],
    ],
    'contents' => [
        'admin' => [
            'layout' => 'admin-layout',
            'template' => 't4web-admin/content/index',
        ],
        'admin-list' => [
            'layout' => 'admin-layout',
            'template' => 't4web-admin/content/list',
        ],
    ],
    'blocks' => [
        't4web-admin-sidebar-menu' => [
            'capture' => 'sidebar-menu',
            'template' => 't4web-admin/block/sidebar-menu',
        ],
        't4web-admin-sidebar-menu-item' => [
            'capture' => 'item',
            'viewModel' => 't4web-admin-viewmodel-sidebar-menu-item',
            'template' => 't4web-admin/block/sidebar-menu-item',
        ],
        't4web-admin-sidebar-treeview-menu-item' => [
            'capture' => 'treeview-item',
            'viewModel' => 't4web-admin-viewmodel-sidebar-menu-item',
            'template' => 't4web-admin/block/sidebar-treeview-menu-item',
        ],
        't4web-admin-top-panel' => [
            'capture' => 'top-panel',
            'template' => 't4web-admin/block/top-panel',
        ],
        't4web-admin-filter' => [
            'viewModel' => \T4web\Admin\ViewModel\FilterFormViewModel::class,
            'template' => 't4web-admin/block/filter',
            'data' => [
                'fromGlobal' => [
                    'validCriteria' => 'validCriteria'
                ]
            ],
            'children' => [
                'form-button-submit' => [
                    'template' => 't4web-admin/block/submit-button',
                    'capture' => 'form-button',
                    'data' => [
                        'static' => [
                            'color' => 'primary',
                            'text' => 'Filter',
                        ],
                    ],
                ],
                'form-button-clear' => [
                    'template' => 't4web-admin/block/link-button',
                    'capture' => 'form-button',
                    'data' => [
                        'static' => [
                            'text' => 'Clear',
                        ],
                    ],
                ],
            ],

        ],
        't4web-admin-form' => [
            'viewModel' => \T4web\Admin\ViewModel\FormViewModel::class,
            'template' => 't4web-admin/block/form',
            'data' => [
                'static' => [
                    'method' => 'post',
                ],
                'fromGlobal' => [
                    'result' => 'result',
                    'criteria' => 'actionRouteOptions',
                    'changes' => 'changes',
                    'changesErrors' => 'changesErrors',
                ],
            ],
            'children' => [
                'form-button-submit' => [
                    'template' => 't4web-admin/block/submit-button',
                    'capture' => 'form-button',
                    'data' => [
                        'static' => [
                            'color' => 'primary',
                        ],
                    ],
                ],
                'form-button-cancel' => [
                    'template' => 't4web-admin/block/link-button',
                    'capture' => 'form-button',
                    'data' => [
                        'static' => [
                            'text' => 'Cancel',
                        ],
                    ],
                ],
            ],

        ],
        't4web-admin-paginator' => [
            'template' => 't4web-admin/block/paginator',
            'data' => [
                'fromGlobal' => 'criteria'
            ]
        ],
    ],
];
