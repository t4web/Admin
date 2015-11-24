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
];