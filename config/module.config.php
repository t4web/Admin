<?php

return [
    'view_manager' => [
        'template_map' => [
            't4web-admin/list' => __DIR__ . '/../view/list.phtml',
            't4web-admin/list-filter' => __DIR__ . '/../view/list-filter.phtml',
            't4web-admin/list-table' => __DIR__ . '/../view/list-table.phtml',
            't4web-admin/list-table-head' => __DIR__ . '/../view/list-table-head.phtml',
            't4web-admin/list-table-head-column' => __DIR__ . '/../view/list-table-head-column.phtml',
            't4web-admin/list-table-row' => __DIR__ . '/../view/list-table-row.phtml',
            't4web-admin/list-table-row-column' => __DIR__ . '/../view/list-table-row-column.phtml',
            't4web-admin/paginator' => __DIR__ . '/../view/paginator.phtml',
        ],
    ],
    'controllers' => [
        'factories' => [
            'T4webAdmin\Controller\List' => 'T4webAdmin\Controller\ListControllerFactory',
			'T4webAdmin\Controller\New' => function() {
                return new T4webAdmin\Controller\NewController();
            }
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
        ],
        'factories' => [
            'T4webAdmin\RouteGenerator' => 'T4webAdmin\RouteGeneratorFactory',
        ],
    ],
];