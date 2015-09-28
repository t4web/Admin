<?php

use Zend\Mvc\Controller\ControllerManager;

return [
    'view_manager' => [
        'template_map' => [
            't4web-admin/list' => __DIR__ . '/../view/list.phtml',
            't4web-admin/list-filter' => __DIR__ . '/../view/list-filter.phtml',
            't4web-admin/list-row' => __DIR__ . '/../view/list-row.phtml',
            't4web-admin/paginator' => __DIR__ . '/../view/paginator.phtml',
        ],
    ],
    'controllers' => [
        'factories' => [
            'T4webAdmin\Controller\List' => function(ControllerManager $controllerManager) {
                /** @var Zend\ServiceManager\ServiceManager $serviceLocator */
                $serviceLocator = $controllerManager->getServiceLocator();
                /** @var Zend\Mvc\Application $app */
                $app = $controllerManager->getServiceLocator()->get('Application');
                /** @var Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                $routeMatch = $app->getMvcEvent()->getRouteMatch();

                $module = $routeMatch->getParam('module');
                $entity = $routeMatch->getParam('entity');
                $umodule = ucfirst($module);
                $uentity = ucfirst($entity);

                $query = $serviceLocator->get('request')->getQuery()->toArray();
                $inputFilter = new T4webAdmin\InputFilter\ListInputFilter($umodule, $uentity);


                $repository = $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository");
                $criteriaFactory = $serviceLocator->get("$umodule\\$uentity\Criteria\CriteriaFactory");
                $finder = new T4webBase\Domain\Service\BaseFinder($repository, $criteriaFactory);

                $viewModel = new T4webAdmin\View\Model\ListViewModel();
                $viewModel->setTemplate('t4web-admin/list');
                $viewModel->setRouteName('admin-' . $module . '-' . $entity);

                $filterViewModel = new T4webAdmin\View\Model\ListFilterViewModel($inputFilter);
                $filterViewModel->setTemplate('t4web-admin/list-filter');
                $viewModel->setRouteName('admin-' . $module . '-' . $entity);

                $paginatorViewModel = new T4webAdmin\View\Model\PaginatorViewModel($inputFilter, $finder);
                $paginatorViewModel->setTemplate('t4web-admin/paginator');

                $listRowHeadViewModel = new T4webAdmin\View\Model\ListRowHeadViewModel();
                $listRowHeadViewModel->setTemplate('t4web-admin/list-row');


                $listColumns = [
                    'Id',
                    'Name',
                    'Link'
                ];

                $listRowViewModel = new T4webAdmin\View\Model\ListRowViewModel();
                $listRowViewModel->setTemplate('t4web-admin/list-row');
                $viewModel->setRouteName('admin-' . $module . '-' . $entity);

                $viewModel->addChild($filterViewModel, 'filter');
                $viewModel->addChild($paginatorViewModel, 'paginator');
                $viewModel->setListRowViewModel($listRowViewModel);

                $instance = new T4webAdmin\Controller\ListController(
                    $query,
                    $inputFilter,
                    $finder,
                    $viewModel
                );

                return $instance;
            },
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
        ],
        'factories' => [
        ],
    ],
];