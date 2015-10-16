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

                $viewModel = new T4webAdmin\View\Model\CreateViewModel();
                $viewModel->setTemplate('t4web-admin/create');
                $viewModel->setVariable('route', $route);

                $formViewModel = new T4webAdmin\View\Model\FormViewModel();
                $formViewModel->setTemplate('t4web-admin/form');
                $formViewModel->setVariable('route', $route);

                if (!empty($config['t4web-admin'][$module][$entity]['form'])) {
                    $formConfig = $config['t4web-admin'][$module][$entity]['form'];

                    foreach ($formConfig as $element) {
                        $template = 't4web-admin/' . $element['type'];

                        $elementView = new Zend\View\Model\ViewModel();
                        $elementView->setTemplate($template);
                        $elementView->setVariables($element['variables']);

                        $formViewModel->addChild($elementView);
                    }
                }

                $viewModel->setFormViewModel($formViewModel);

                return new T4webAdmin\Controller\NewController($viewModel);
            },
            'T4webAdmin\Controller\Create' => function($controllerManager) {

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


                /** @var EventManager $eventManager */
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
                $route = 'admin-' . $module . '-' . $entity;

                $viewModel = new T4webAdmin\View\Model\CreateViewModel();
                $viewModel->setTemplate('t4web-admin/create');
                $viewModel->setVariable('route', $route);

                $formViewModel = new T4webAdmin\View\Model\FormViewModel();
                $formViewModel->setTemplate('t4web-admin/form');
                $formViewModel->setVariable('route', $route);

                if (!empty($config['t4web-admin'][$module][$entity]['form'])) {
                    $formConfig = $config['t4web-admin'][$module][$entity]['form'];

                    foreach ($formConfig as $element) {
                        $template = 't4web-admin/' . $element['type'];

                        $elementView = new Zend\View\Model\ViewModel();
                        $elementView->setTemplate($template);
                        $elementView->setVariables($element['variables']);

                        $formViewModel->addChild($elementView);
                    }
                }

                $viewModel->setFormViewModel($formViewModel);

                return new T4webAdmin\Controller\CreateController(
                    $post,
                    $creator,
                    $viewModel,
                    $route);
            },
            'T4webAdmin\Controller\Read' => function($controllerManager) {

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

                $repository = $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository");
                $criteriaFactory = $serviceLocator->get("$umodule\\$uentity\Criteria\CriteriaFactory");
                $finder = new T4webBase\Domain\Service\BaseFinder($repository, $criteriaFactory);

                $viewModel = new T4webAdmin\View\Model\ReadViewModel();
                $viewModel->setTemplate('t4web-admin/read');

                $formViewModel = new T4webAdmin\View\Model\FormViewModel();
                $formViewModel->setTemplate('t4web-admin/form');
                $formViewModel->setVariable('route', $route);
                $formViewModel->setVariable('controller', 'update');
                $formViewModel->setVariable('submitText', 'Update');

                if (!empty($config['t4web-admin'][$module][$entity]['form'])) {
                    $formConfig = $config['t4web-admin'][$module][$entity]['form'];

                    foreach ($formConfig as $element) {
                        $template = 't4web-admin/' . $element['type'];

                        $elementView = new Zend\View\Model\ViewModel();
                        $elementView->setTemplate($template);
                        $elementView->setVariables($element['variables']);

                        $formViewModel->addChild($elementView);
                    }
                }

                $viewModel->setFormViewModel($formViewModel);

                return new T4webAdmin\Controller\ReadController($finder, $viewModel);
            },
            'T4webAdmin\Controller\Update' => function($controllerManager) {

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

                /** @var EventManager $eventManager */
                $eventManager = $serviceLocator->get('EventManager');
                $eventManager->addIdentifiers("$umodule\\$uentity\Service\Updater");

                $updater = new T4webBase\Domain\Service\Update(
                    $inputFilter,
                    $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository"),
                    $serviceLocator->get("$umodule\\$uentity\Factory\CriteriaFactory"),
                    $eventManager
                );

                $viewModel = new T4webAdmin\View\Model\UpdateViewModel();
                $viewModel->setTemplate('t4web-admin/update');

                $formViewModel = new T4webAdmin\View\Model\FormViewModel();
                $formViewModel->setTemplate('t4web-admin/form');
                $formViewModel->setVariable('route', $route);
                $formViewModel->setVariable('controller', 'update');
                $formViewModel->setVariable('submitText', 'Update');

                if (!empty($config['t4web-admin'][$module][$entity]['form'])) {
                    $formConfig = $config['t4web-admin'][$module][$entity]['form'];

                    foreach ($formConfig as $element) {
                        $template = 't4web-admin/' . $element['type'];

                        $elementView = new Zend\View\Model\ViewModel();
                        $elementView->setTemplate($template);
                        $elementView->setVariables($element['variables']);

                        $formViewModel->addChild($elementView);
                    }
                }

                $viewModel->setFormViewModel($formViewModel);

                $id = $routeMatch->getParam('id');
                $post = $serviceLocator->get('request')->getPost()->toArray();

                return new T4webAdmin\Controller\UpdateController($id, $post, $updater, $viewModel, $route);
            },
            'T4webAdmin\Controller\Delete' => function($controllerManager) {

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

                /** @var EventManager $eventManager */
                $eventManager = $serviceLocator->get('EventManager');
                $eventManager->addIdentifiers("$umodule\\$uentity\Service\Deleter");

                $deleter = new T4webBase\Domain\Service\Delete(
                    $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository"),
                    $serviceLocator->get("$umodule\\$uentity\Factory\CriteriaFactory"),
                    $eventManager
                );

                $viewModel = new T4webAdmin\View\Model\DeleteViewModel();

                $id = $routeMatch->getParam('id');

                return new T4webAdmin\Controller\DeleteController($id, $deleter, $viewModel, $route);
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