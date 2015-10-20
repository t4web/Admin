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
            'T4webAdmin\Controller\New' => function(Zend\Mvc\Controller\ControllerManager $controllerManager) {
                $serviceLocator = $controllerManager->getServiceLocator();
                return new T4webAdmin\Controller\NewController($serviceLocator->get('T4webAdmin\View\Model\CreateViewModel'));
            },
            'T4webAdmin\Controller\Create' => function(Zend\Mvc\Controller\ControllerManager $controllerManager) {
                $serviceLocator = $controllerManager->getServiceLocator();
                /** @var T4webAdmin\Config $config */
                $config = $serviceLocator->get('T4webAdmin\Config');

                $post = $serviceLocator->get('request')->getPost()->toArray();
                $creator = $serviceLocator->get('T4webAdmin\Service\CreatorService');
                $viewModel = $serviceLocator->get('T4webAdmin\View\Model\CreateViewModel');
                $redirectToRoute = $config->getCreateRedirectTo();

                return new Sebaks\Crud\Controller\CreateController($post, $creator, $viewModel, $redirectToRoute);
            },
            'T4webAdmin\Controller\Read' => function(Zend\Mvc\Controller\ControllerManager $controllerManager) {
                $serviceLocator = $controllerManager->getServiceLocator();

                $finder = $serviceLocator->get('T4webAdmin\Service\FinderService');
                $viewModel = $serviceLocator->get('T4webAdmin\View\Model\ReadViewModel');

                return new Sebaks\Crud\Controller\ReadController($finder, $viewModel);
            },
            'T4webAdmin\Controller\Update' => function(Zend\Mvc\Controller\ControllerManager $controllerManager) {
                $serviceLocator = $controllerManager->getServiceLocator();
                /** @var T4webAdmin\Config $config */
                $config = $serviceLocator->get('T4webAdmin\Config');

                /** @var \Zend\Mvc\Application $app */
                $app = $serviceLocator->get('Application');
                /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                $routeMatch = $app->getMvcEvent()->getRouteMatch();

                $id = $routeMatch->getParam('id');
                $post = $serviceLocator->get('request')->getPost()->toArray();
                $updater = $serviceLocator->get('T4webAdmin\Service\UpdaterService');
                $viewModel = $serviceLocator->get('T4webAdmin\View\Model\UpdateViewModel');
                $redirectToRoute = $config->getCreateRedirectTo();

                return new Sebaks\Crud\Controller\UpdateController($id, $post, $updater, $viewModel, $redirectToRoute);
            },
            'T4webAdmin\Controller\Delete' => function(Zend\Mvc\Controller\ControllerManager $controllerManager) {

                $serviceLocator = $controllerManager->getServiceLocator();

                /** @var \Zend\Mvc\Application $app */
                $app = $serviceLocator->get('Application');
                /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                $routeMatch = $app->getMvcEvent()->getRouteMatch();

                $module = $routeMatch->getParam('module');
                $entity = $routeMatch->getParam('entity');
                $umodule = ucfirst($module);
                $uentity = ucfirst($entity);

                $route = 'admin-' . $module . '-' . $entity;

                /** @var Zend\EventManager\EventManager $eventManager */
                $eventManager = $serviceLocator->get('EventManager');
                $eventManager->addIdentifiers("$umodule\\$uentity\Service\Deleter");

                $deleter = new T4webBase\Domain\Service\Delete(
                    $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository"),
                    $serviceLocator->get("$umodule\\$uentity\Factory\CriteriaFactory"),
                    $eventManager
                );

                $viewModel = new Sebaks\Crud\View\Model\DeleteViewModel();

                $id = $routeMatch->getParam('id');

                return new Sebaks\Crud\Controller\DeleteController($id, $deleter, $viewModel, $route);
            },
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
        ],
        'factories' => [
            'T4webAdmin\RouteGenerator' => 'T4webAdmin\RouteGeneratorFactory',
            'T4webAdmin\Config' => 'T4webAdmin\ConfigFactory',
            'T4webAdmin\View\Model\NewViewModel' => 'T4webAdmin\View\Model\NewViewModelFactory',
            'T4webAdmin\View\Model\CreateViewModel' => 'T4webAdmin\View\Model\CreateViewModelFactory',
            'T4webAdmin\View\Model\ReadViewModel' => 'T4webAdmin\View\Model\ReadViewModelFactory',
            'T4webAdmin\View\Model\UpdateViewModel' => 'T4webAdmin\View\Model\UpdateViewModelFactory',
            'T4webAdmin\View\Model\FormViewModel' => 'T4webAdmin\View\Model\FormViewModelFactory',
            'T4webAdmin\Service\CreatorService' => 'T4webAdmin\Service\CreatorServiceFactory',
            'T4webAdmin\Service\UpdaterService' => 'T4webAdmin\Service\UpdaterServiceFactory',
            'T4webAdmin\Service\FinderService' => 'T4webAdmin\Service\FinderServiceFactory',
        ],
    ],
];