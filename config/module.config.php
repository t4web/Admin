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

//            'T4webAdmin\Controller\Update' => function(Zend\Mvc\Controller\ControllerManager $controllerManager) {
//                $serviceLocator = $controllerManager->getServiceLocator();
//                /** @var T4webAdmin\Config $config */
//                $config = $serviceLocator->get('T4webAdmin\Config');
//                /** @var \Zend\Mvc\Application $app */
//                $app = $serviceLocator->get('Application');
//                /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
//                $routeMatch = $app->getMvcEvent()->getRouteMatch();
//
//                $id = $routeMatch->getParam('id');
//                $post = $serviceLocator->get('request')->getPost()->toArray();
//                $updater = $serviceLocator->get('T4webAdmin\Service\UpdaterService');
//                $viewModel = $serviceLocator->get('T4webAdmin\View\Model\UpdateViewModel');
//                $redirectToRoute = $config->getCreateRedirectTo();
//
//                return new Sebaks\Crud\Controller\UpdateController($id, $post, $updater, $viewModel, $redirectToRoute);
//            },
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
        ],
        'factories' => [
            'T4webAdmin\Config' => 'T4webAdmin\ConfigFactory',
            'T4webAdmin\RouteGenerator' => 'T4webAdmin\RouteGeneratorFactory',
            'T4webAdmin\Service\FinderService' => 'T4webAdmin\Service\FinderServiceFactory',

            't4web-admin-view-model-paginator' => function(Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
                $app = $serviceLocator->get('Application');
                /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                $routeMatch = $app->getMvcEvent()->getRouteMatch();

                $module = $routeMatch->getParam('module');
                $entity = $routeMatch->getParam('entity');
                /** @var \Zend\Http\PhpEnvironment\Request $request */
                $request = $app->getMvcEvent()->getRequest();

                $repository = $serviceLocator->get(ucfirst($module) . "\\" . ucfirst($entity) . "\\Infrastructure\\Repository");

                $filter = new T4webFilter\Filter();

                return new T4webAdmin\View\Model\PaginatorViewModel(
                    $repository,
                    $filter->prepare($request->getQuery()->toArray())
                );
            }
        ],

        'invokables' => [
            't4web-admin-view-model-list' => 'T4webAdmin\View\Model\ListViewModel',
            't4web-admin-view-model-read' => 'T4webAdmin\View\Model\ReadViewModel',
            't4web-admin-view-model-create' => 'T4webAdmin\View\Model\CreateViewModel',
            't4web-admin-view-model-update' => 'T4webAdmin\View\Model\UpdateViewModel',
        ],
    ],
];