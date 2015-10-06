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
            't4web-admin/create' => __DIR__ . '/../view/create.phtml',
            't4web-admin/read' => __DIR__ . '/../view/read.phtml',
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

                $viewModel = new T4webAdmin\View\Model\NewViewModel();
                $viewModel->setTemplate('t4web-admin/new');
                $viewModel->setVariable('route', 'admin-' . $module . '-' . $entity);
                $viewModel->setForm(new Zend\Form\Form());

                return new T4webAdmin\Controller\NewController($viewModel);
            },
            'T4webAdmin\Controller\Create' => function($controllerManager) {

                $serviceLocator = $controllerManager->getServiceLocator();
                /** @var \Zend\Mvc\Application $app */
                $app = $serviceLocator->get('Application');
                /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                $routeMatch = $app->getMvcEvent()->getRouteMatch();

                $module = $routeMatch->getParam('module');
                $entity = $routeMatch->getParam('entity');
                $umodule = ucfirst($module);
                $uentity = ucfirst($entity);


                $post = $serviceLocator->get('request')->getPost()->toArray();

                $inputFilter = new T4webAdmin\InputFilter\CreateInputFilter($umodule, $uentity);

                /** @var EventManager $eventManager */
                $eventManager = $serviceLocator->get('EventManager');
                $eventManager->addIdentifiers("$umodule\\$uentity\Service\Creator");

                $creator = new T4webBase\Domain\Service\NewCreate(
                    $inputFilter,
                    $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository"),
                    $serviceLocator->get("$umodule\\$uentity\Factory\EntityFactory"),
                    $eventManager
                );

                $viewModel = new T4webAdmin\View\Model\CreateViewModel();
                $viewModel->setTemplate('t4web-admin/create');

                return new T4webAdmin\Controller\CreateController($post, $creator, $viewModel);
            },
            'T4webAdmin\Controller\Read' => function($controllerManager) {

                $serviceLocator = $controllerManager->getServiceLocator();
                /** @var \Zend\Mvc\Application $app */
                $app = $serviceLocator->get('Application');
                /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                $routeMatch = $app->getMvcEvent()->getRouteMatch();

                $module = $routeMatch->getParam('module');
                $entity = $routeMatch->getParam('entity');
                $umodule = ucfirst($module);
                $uentity = ucfirst($entity);

                $repository = $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository");
                $criteriaFactory = $serviceLocator->get("$umodule\\$uentity\Criteria\CriteriaFactory");
                $finder = new T4webBase\Domain\Service\BaseFinder($repository, $criteriaFactory);

                $viewModel = new T4webAdmin\View\Model\ReadViewModel();
                $viewModel->setTemplate('t4web-admin/read');

                return new T4webAdmin\Controller\ReadController($finder, $viewModel);
            },
            'T4webAdmin\Controller\Update' => function($controllerManager) {

                $serviceLocator = $controllerManager->getServiceLocator();
                /** @var \Zend\Mvc\Application $app */
                $app = $serviceLocator->get('Application');
                /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                $routeMatch = $app->getMvcEvent()->getRouteMatch();

                $module = $routeMatch->getParam('module');
                $entity = $routeMatch->getParam('entity');
                $umodule = ucfirst($module);
                $uentity = ucfirst($entity);


                die(var_dump(T4webAdmin\Controller\UpdateController()));

                return new T4webAdmin\Controller\CreateController($post, $creator, $viewModel);
            },
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