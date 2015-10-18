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
                /** @var T4webAdmin\View\Model\NewViewModel $serviceLocator */
                $serviceLocator = $controllerManager->getServiceLocator();
                return new T4webAdmin\Controller\NewController($serviceLocator->get('T4webAdmin\View\Model\NewViewModel'));
            },
            'T4webAdmin\Controller\Create' => function(Zend\Mvc\Controller\ControllerManager $controllerManager) {

                $serviceLocator = $controllerManager->getServiceLocator();

                $config = $serviceLocator->get('config');

                /** @var \Zend\Mvc\Application $app */
                $app = $serviceLocator->get('Application');
                /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                $routeMatch = $app->getMvcEvent()->getRouteMatch();

                $module = $routeMatch->getParam('module');
                $entity = $routeMatch->getParam('entity');
                $umodule = ucfirst($module);
                $uentity = ucfirst($entity);


                // creator
                $inputFilterConfig = [];
                if (!empty($config['t4web-admin'][$module][$entity]['validation'])) {
                    $inputFilterConfig = $config['t4web-admin'][$module][$entity]['validation'];
                }

                $inputFilterFactory = new Zend\InputFilter\Factory();
                $inputFilter = $inputFilterFactory->createInputFilter($inputFilterConfig);


                /** @var Zend\EventManager\EventManager $eventManager */
                $eventManager = $serviceLocator->get('EventManager');
                $eventManager->addIdentifiers("$umodule\\$uentity\Service\Creator");

                $creator = new T4webBase\Domain\Service\NewCreate(
                    $inputFilter,
                    $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository"),
                    $serviceLocator->get("$umodule\\$uentity\Factory\EntityFactory"),
                    $eventManager
                );

                // data
                $post = $serviceLocator->get('request')->getPost()->toArray();

                // view

                $viewModel = new T4webAdmin\View\Model\CreateViewModel();
                $viewModel->setTemplate('t4web-admin/entity-manage');
                $viewModel->setVariable('title', 'Create new entity');

                $formViewModel = $serviceLocator->get('T4webAdmin\View\Model\FormViewModel');
                $viewModel->setFormViewModel($formViewModel);

                $route = 'admin-' . $module . '-' . $entity;

                return new Sebaks\Crud\Controller\CreateController(
                    $post,
                    $creator,
                    $viewModel,
                    $route);
            },
            'T4webAdmin\Controller\Read' => function(Zend\Mvc\Controller\ControllerManager $controllerManager) {

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
                $viewModel->setTemplate('t4web-admin/entity-manage');
                $viewModel->setVariable('title', 'Edit entity');

                $formViewModel = $serviceLocator->get('T4webAdmin\View\Model\FormViewModel');
                $viewModel->setFormViewModel($formViewModel);

                return new Sebaks\Crud\Controller\ReadController($finder, $viewModel);
            },
            'T4webAdmin\Controller\Update' => function(Zend\Mvc\Controller\ControllerManager $controllerManager) {

                $serviceLocator = $controllerManager->getServiceLocator();

                $config = $serviceLocator->get('config');

                /** @var \Zend\Mvc\Application $app */
                $app = $serviceLocator->get('Application');
                /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                $routeMatch = $app->getMvcEvent()->getRouteMatch();

                $module = $routeMatch->getParam('module');
                $entity = $routeMatch->getParam('entity');
                $umodule = ucfirst($module);
                $uentity = ucfirst($entity);

                $route = 'admin-' . $module . '-' . $entity;

                $inputFilterConfig = [];
                if (!empty($config['t4web-admin'][$module][$entity]['validation'])) {
                    $inputFilterConfig = $config['t4web-admin'][$module][$entity]['validation'];
                }

                $inputFilterFactory = new Zend\InputFilter\Factory();
                $inputFilter = $inputFilterFactory->createInputFilter($inputFilterConfig);

                /** @var Zend\EventManager\EventManager $eventManager */
                $eventManager = $serviceLocator->get('EventManager');
                $eventManager->addIdentifiers("$umodule\\$uentity\Service\Updater");

                $updater = new T4webBase\Domain\Service\Update(
                    $inputFilter,
                    $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository"),
                    $serviceLocator->get("$umodule\\$uentity\Factory\CriteriaFactory"),
                    $eventManager
                );

                $viewModel = new T4webAdmin\View\Model\UpdateViewModel();
                $viewModel->setTemplate('t4web-admin/entity-manage');
                $viewModel->setVariable('title', 'Edit entity');

                $formViewModel = $serviceLocator->get('T4webAdmin\View\Model\FormViewModel');
                $viewModel->setFormViewModel($formViewModel);

                $id = $routeMatch->getParam('id');
                $post = $serviceLocator->get('request')->getPost()->toArray();

                return new Sebaks\Crud\Controller\UpdateController($id, $post, $updater, $viewModel, $route);
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
            'T4webAdmin\View\Model\FormViewModel' => 'T4webAdmin\View\Model\FormViewModelFactory',
        ],
    ],
];