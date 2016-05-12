<?php

return array(
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
    'view_manager' => [
        'template_path_stack' => [
            't4web-admin' => __DIR__ . '/../view',
        ],
    ],
    'sebaks-view' => include 'sebaks-view.config.php',
    'service_manager' => [
        'abstract_factories' => [
            T4web\Admin\ViewModel\PaginatorViewModelAbstractFactory::class,
        ],
        'factories' => [
            't4web-admin-viewmodel-sidebar-menu-item' => \T4web\Admin\ViewModel\SidebarItemsViewModelFactory::class,
            't4web-admin-viewmodel-sidebar-treeview-menu-item' => \T4web\Admin\ViewModel\SidebarItemsViewModelFactory::class,
        ],
        'invokables' => [
            \T4web\Admin\ViewModel\TableViewModel::class => \T4web\Admin\ViewModel\TableViewModel::class,
            \T4web\Admin\ViewModel\TableRowViewModel::class => \T4web\Admin\ViewModel\TableRowViewModel::class,
            \T4web\Admin\ViewModel\FormViewModel::class => \T4web\Admin\ViewModel\FormViewModel::class,
            \T4web\Admin\ViewModel\FilterFormViewModel::class => \T4web\Admin\ViewModel\FilterFormViewModel::class,
            \T4web\Admin\ViewModel\EditButtonViewModel::class => \T4web\Admin\ViewModel\EditButtonViewModel::class,
            \T4web\Admin\ViewModel\UpdateFormViewModel::class => \T4web\Admin\ViewModel\UpdateFormViewModel::class,
        ],
    ],
);
