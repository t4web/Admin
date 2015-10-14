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
			'T4webAdmin\Controller\New' => function($controllerManager) {

                $serviceLocator = $controllerManager->getServiceLocator();

                $config = $serviceLocator->get('config');

                /** @var \Zend\Mvc\Application $app */
                $app = $serviceLocator->get('Application');
                /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                $routeMatch = $app->getMvcEvent()->getRouteMatch();

                $module = $routeMatch->getParam('module');
                $entity = $routeMatch->getParam('entity');

                $route = 'admin-' . $module . '-' . $entity;

                $viewModel = new Zend\View\Model\ViewModel();
                $viewModel->setTemplate('t4web-admin/new');
                $viewModel->setVariable('route', $route);

                $formView = new Zend\View\Model\ViewModel();
                $formView->setTemplate('t4web-admin/form');
                $formView->setVariable('route', $route);

                if (!empty($config['t4web-admin'][$module][$entity]['new']['form'])) {
                    $formConfig = $config['t4web-admin'][$module][$entity]['new']['form'];

                    foreach ($formConfig as $element) {
                        $template = 't4web-admin/' . $element['type'];

                        $elementView = new Zend\View\Model\ViewModel();
                        $elementView->setTemplate($template);
                        $elementView->setVariables($element['variables']);

                        $formView->addChild($elementView);
                    }
                }

                $viewModel->addChild($formView, 'form');

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