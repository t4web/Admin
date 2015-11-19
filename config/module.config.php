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

            'T4webAdmin\Controller\New' => function(Zend\Mvc\Controller\ControllerManager $controllerManager) {

                $serviceLocator = $controllerManager->getServiceLocator();

                /** @var T4webAdmin\Config $config */
                $config = $serviceLocator->get('T4webAdmin\Config');

                $viewModel = $serviceLocator->get($config->getActionViewModel());

                return new T4webAdmin\Controller\NewController($viewModel);
            },
            'T4webAdmin\Controller\Create' => function(Zend\Mvc\Controller\ControllerManager $controllerManager) {
                $serviceLocator = $controllerManager->getServiceLocator();
                /** @var T4webAdmin\Config $config */
                $config = $serviceLocator->get('T4webAdmin\Config');

                $post = $serviceLocator->get('request')->getPost()->toArray();
                $creator = $serviceLocator->get('T4webAdmin\Service\CreatorService');

                $viewModel = $serviceLocator->get($config->getActionViewModel());
                $redirectTo = $config->getActionRedirect();

                return new Sebaks\Crud\Controller\CreateController($post, $creator, $viewModel, $redirectTo);
            },
//            'T4webAdmin\Controller\Read' => function(Zend\Mvc\Controller\ControllerManager $controllerManager) {
//
//                $serviceLocator = $controllerManager->getServiceLocator();
//
//                /** @var T4webAdmin\Config $config */
//                $config = $serviceLocator->get('T4webAdmin\Config');
//
//                $finder = $serviceLocator->get('T4webAdmin\Service\FinderService');
//
//                $viewModel = new \T4webAdmin\View\Model\BaseViewModel();
//                $viewModel->setName('t4web-admin-view-model-read');
//                $viewModel->setTemplate('t4web-admin/entity-manage');
//
//                //$viewModel = $serviceLocator->get($config->getActionViewModel());
//
//                return new Sebaks\Crud\Controller\ReadController($finder, $viewModel);
//            },
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
                /** @var T4webAdmin\Config $config */
                $config = $serviceLocator->get('T4webAdmin\Config');
                /** @var \Zend\Mvc\Application $app */
                $app = $serviceLocator->get('Application');
                /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                $routeMatch = $app->getMvcEvent()->getRouteMatch();

                $id = $routeMatch->getParam('id');
                $viewModel = new Sebaks\Crud\View\Model\DeleteViewModel();
                $deleter = $serviceLocator->get('T4webAdmin\Service\DeleterService');
                $redirectToRoute = $config->getCreateRedirectTo();

                return new Sebaks\Crud\Controller\DeleteController($id, $deleter, $viewModel, $redirectToRoute);
            },
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'T4webAdmin\View\Model\BaseViewModelAbstractFactory'
//            't4web-admin-view-component-list' => 'T4webAdmin\View\Model\BaseViewModelAbstractFactory',
//            't4web-admin-view-model-create' => 'T4webAdmin\View\Model\BaseViewModelAbstractFactory',
//            't4web-admin-view-model-read' => 'T4webAdmin\View\Model\BaseViewModelAbstractFactory',
        ],
        'factories' => [
            'T4webAdmin\Config' => 'T4webAdmin\ConfigFactory',
            'T4webAdmin\RouteGenerator' => 'T4webAdmin\RouteGeneratorFactory',
            //'T4webAdmin\View\Model\UpdateViewModel' => 'T4webAdmin\View\Model\UpdateViewModelFactory',
            //'T4webAdmin\Service\CreatorService' => 'T4webAdmin\Service\CreatorServiceFactory',
            //'T4webAdmin\Service\UpdaterService' => 'T4webAdmin\Service\UpdaterServiceFactory',
            'T4webAdmin\Service\FinderService' => 'T4webAdmin\Service\FinderServiceFactory',
            //'T4webAdmin\Service\DeleterService' => 'T4webAdmin\Service\DeleterServiceFactory',
        ],

        'invokables' => [
            't4web-admin-view-model-list' => 'T4webAdmin\View\Model\ListViewModel',
            't4web-admin-view-model-list-filter' => 'T4webAdmin\View\Model\BaseViewModel',
            't4web-admin-view-model-list-table' => 'T4webAdmin\View\Model\BaseViewModel',

            't4web-admin-view-model-read' => 'T4webAdmin\View\Model\ReadViewModel',
        ],
    ],
];