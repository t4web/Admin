<?php

return [
    'router' => [
        'routes' => [
            'admin' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/admin',
                    'defaults' => [
                        'controller' => 'sebaks-zend-mvc-controller',
                        'allowedMethods' => ['GET'],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => array(
        'template_path_stack' => array(
            't4web-admin' => __DIR__ . '/../view',
        ),
    ),
    'controllers' => [
        'invokables' => [
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'T4web\Admin\ViewModel\EntityReadViewModel' => 'T4web\Admin\ViewModel\EntityReadViewModel',
            'T4web\Admin\ViewModel\EntityListViewModel' => 'T4web\Admin\ViewModel\EntityListViewModel',
        ],
        'factories' => [
        ],
    ],
    'sebaks-view' => [
        'layouts' => [
            'admin' => [
                'template' => 'layout/admin',
                'children' => [
                    'top-panel' => 't4web-admin-top-panel',
                    'sidebar-menu' => 't4web-admin-sidebar-menu',
                ],
            ]
        ],
        'contents' => [
            'admin' => [
                'template' => 't4web-admin/index/index.phtml',
                'layout' => 'admin',
            ]
        ],
        'blocks' => [
            't4web-admin-sidebar-menu' => [
                'template' => 't4web-admin/sidebar-menu',
            ],
            't4web-admin-sidebar-menu-item' => [
                'template' => 't4web-admin/sidebar-menu-item',
            ],
            't4web-admin-sidebar-treeview-menu-item' => [
                'template' => 't4web-admin/sidebar-treeview-menu-item',
            ],
            't4web-admin-top-panel' => [
                'template' => 't4web-admin/top-panel',
            ],
            't4web-admin-list' => [
                'template' => 't4web-admin/list',
                'viewModel' => 'T4web\Admin\ViewModel\EntityListViewModel',
                'variables' => [
                    'title' => 'List of entities',
                ],
                'children' => [
                    'filter' => 't4web-admin-list-filter',
                    'table' => 't4web-admin-list-table',
                    'paginator' => 't4web-admin-list-paginator',
                ],
            ],
            't4web-admin-list-filter' => [
                'template' => 't4web-admin/list-filter',
            ],
            't4web-admin-list-table' => [
                'template' => 't4web-admin/list-table',
                'children' => [
                    'table-head' => 't4web-admin-list-table-head',
                    'table-row' => 't4web-admin-list-table-row',
                ],
            ],
            't4web-admin-list-paginator' => [
                'template' => 't4web-paginator/paginator',
            ],
            't4web-admin-list-table-head' => [
                'template' => 't4web-admin/list-table-head',
                'children' => [
                ],
            ],
            't4web-admin-list-table-head-column' => [
                'template' => 't4web-admin/list-table-head-column',
            ],
            't4web-admin-list-table-row' => [
                'template' => 't4web-admin/list-table-row',
            ],
            't4web-admin-list-table-row-column' => [
                'template' => 't4web-admin/list-table-row-column',
            ],
            't4web-admin-read' => [
                'template' => 't4web-admin/entity-read',
                'viewModel' => 'T4web\Admin\ViewModel\EntityReadViewModel',
                'variables' => [
                    'title' => 'Read entity',
                    'submitRoute' => '',
                    'cancelRoute' => '',
                ],
                'children' => [
                    'form' => [
                        'extend' => 't4web-admin-form',
                        'variables' => [
                            'submitText' => 'Save',
                        ],
                    ],
                ],
            ],
            't4web-admin-update' => [
                'template' => 't4web-admin/entity-update',
                'variables' => [
                    'title' => 'Update entity',
                    'submitRoute' => '',
                    'cancelRoute' => '',
                ],
                'children' => [
                    'form' => 't4web-admin-form',
                ],
            ],
            't4web-admin-form' => [
                'template' => 't4web-admin/form',
                'variables' => [
                    'submitText' => 'Create',
                    'cancelText' => 'Cancel',
                ],
            ],
            't4web-admin-form-element-text' => [
                'template' => 't4web-admin/form-element-text',
            ],
            't4web-admin-form-element-select' => [
                'template' => 't4web-admin/form-element-select',
            ],

            't4web-admin-create' => [
                'template' => 't4web-admin/entity-create',
                'variables' => [
                    'title' => 'Create new entity',
                ],
                'children' => [
                    'form' => 't4web-admin-form'
                ],
            ],
        ],
    ],
];