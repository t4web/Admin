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
            't4web-admin/new' => __DIR__ . '/../view/new.phtml',
        ],
    ],
    'controllers' => [
        'factories' => [
            'T4webAdmin\Controller\List' => 'T4webAdmin\Controller\ListControllerFactory',
			'T4webAdmin\Controller\New' => function($controllerManager) {
                $serviceLocator = $controllerManager->getServiceLocator();
                /** @var \Zend\Mvc\Application $app */
                $app = $serviceLocator->get('Application');
                /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                $routeMatch = $app->getMvcEvent()->getRouteMatch();

                $module = $this->module = $routeMatch->getParam('module');
                $entity = $this->entity = $routeMatch->getParam('entity');

                $viewModel = new Zend\View\Model\ViewModel();
                $viewModel->setTemplate('t4web-admin/new');
                $viewModel->setVariable('route', 'admin-' . $module . '-' . $entity);

                return new T4webAdmin\Controller\NewController($viewModel);
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