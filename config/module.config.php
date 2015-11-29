<?php

return [
    'view_manager' => array(
        'template_path_stack' => array(
            't4web-admin' => __DIR__ . '/../view',
        ),
    ),
    'controllers' => [
        'factories' => [
            'T4webAdmin\Controller\List' => 'T4webAdmin\Controller\ListControllerFactory',
            'T4webAdmin\Controller\Read' => 'T4webAdmin\Controller\ReadControllerFactory',
            'T4webAdmin\Controller\New' => 'T4webAdmin\Controller\NewControllerFactory',
            'T4webAdmin\Controller\Create' => 'T4webAdmin\Controller\CreateControllerFactory',
            'T4webAdmin\Controller\Update' => 'T4webAdmin\Controller\UpdateControllerFactory',
            'T4webAdmin\Controller\Delete' => 'T4webAdmin\Controller\DeleteControllerFactory',
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'T4webAdmin\View\Model\BaseViewModelAbstractFactory'
        ],
        'factories' => [
            'T4webAdmin\Config' => 'T4webAdmin\ConfigFactory',
            'T4webAdmin\RouteGenerator' => 'T4webAdmin\RouteGeneratorFactory',
            'T4webAdmin\Service\FinderService' => 'T4webAdmin\Service\FinderServiceFactory',
            't4web-admin-view-model-paginator' => 'T4webAdmin\View\Model\PaginatorFactory',
        ],

        'invokables' => [
            't4web-admin-view-model-list' => 'T4webAdmin\View\Model\ListViewModel',
            't4web-admin-view-model-read' => 'T4webAdmin\View\Model\ReadViewModel',
            't4web-admin-view-model-create' => 'T4webAdmin\View\Model\CreateViewModel',
            't4web-admin-view-model-update' => 'T4webAdmin\View\Model\UpdateViewModel',
            't4web-admin-view-model-delete' => 'T4webAdmin\View\Model\DeleteViewModel',
        ],
    ],
    't4web-admin' => [
        'viewComponents' => [

            't4web-admin-view-component-list' => [
                'template' => 't4web-admin/list',
                'viewModel' => 't4web-admin-view-model-list',
                'variables' => [
                    'title' => 'List of entities',
                ],
                'children' => [
                    'filter' => 't4web-admin-view-component-list-filter',
                    'table' => 't4web-admin-view-component-list-table',
                    'paginator' => 't4web-admin-view-component-list-paginator',
                ],
            ],
            't4web-admin-view-component-list-filter' => [
                'template' => 't4web-admin/list-filter',
            ],
            't4web-admin-view-component-list-table' => [
                'template' => 't4web-admin/list-table',
                'children' => [
                    't4web-admin-view-component-list-table-head',
                    't4web-admin-view-component-list-table-row',
                ],
            ],
            't4web-admin-view-component-list-paginator' => [
                'template' => 't4web-admin/paginator',
                'viewModel' => 't4web-admin-view-model-paginator',
            ],
            't4web-admin-view-component-list-table-head' => [
                'template' => 't4web-admin/list-table-head',
                'children' => [
                    't4web-admin-view-component-list-table-head-column',
                ],
            ],
            't4web-admin-view-component-list-table-head-column' => [
                'template' => 't4web-admin/list-table-head-column',
            ],
            't4web-admin-view-component-list-table-row' => [
                'template' => 't4web-admin/list-table-row',
            ],
            't4web-admin-view-component-list-table-row-column' => [
                'template' => 't4web-admin/list-table-row-column',
            ],

            't4web-admin-view-component-read' => [
                'template' => 't4web-admin/entity-manage',
                'viewModel' => 't4web-admin-view-model-read',
                'variables' => [
                    'title' => 'Read entity',
                    'submitRoute' => '',
                    'cancelRoute' => '',
                ],
                'children' => [
                    'form' => 't4web-admin-view-component-form',
                ],
            ],

            't4web-admin-view-component-update' => [
                'template' => 't4web-admin/entity-manage',
                'viewModel' => 't4web-admin-view-model-update',
                'variables' => [
                    'title' => 'Update entity',
                    'submitRoute' => '',
                    'cancelRoute' => '',
                ],
                'children' => [
                    'form' => 't4web-admin-view-component-form',
                ],
            ],
            't4web-admin-view-component-form' => [
                'template' => 't4web-admin/form',
                'variables' => [
                    'submitText' => 'Create',
                    'cancelText' => 'Cancel',
                ],
            ],

            't4web-admin-view-component-form-element-text' => [
                'template' => 't4web-admin/form-element-text',
            ],
            't4web-admin-view-component-form-element-select' => [
                'template' => 't4web-admin/form-element-select',
            ],

            't4web-admin-view-component-create' => [
                'template' => 't4web-admin/entity-manage',
                'viewModel' => 't4web-admin-view-model-create',
                'variables' => [
                    'title' => 'Create new entity',
                ],
                'children' => [
                    'form' => 't4web-admin-view-component-form'
                ],
            ],
        ]
    ],
];