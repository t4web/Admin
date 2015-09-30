<?php

use Zend\Mvc\Controller\ControllerManager;

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

                // View

                $viewModel = new T4webAdmin\View\Model\ListViewModel();
                $viewModel->setTemplate('t4web-admin/list');
                $viewModel->setVariable('route', 'admin-' . $module . '-' . $entity);

                // FilterView
                $filterViewModel = new T4webAdmin\View\Model\ListFilterViewModel($inputFilter);
                $filterViewModel->setTemplate('t4web-admin/list-filter');

                // PaginatorView
                $paginatorViewModel = new T4webAdmin\View\Model\PaginatorViewModel($inputFilter, $finder);
                $paginatorViewModel->setTemplate('t4web-admin/paginator');

                // TableView
                $tableViewModel = new T4webAdmin\View\Model\TableViewModel();
                $tableViewModel->setTemplate('t4web-admin/list-table');
                $tableViewModel->setVariables($viewModel->getVariables());


                // head
                $config = $serviceLocator->get('config');

                if (!empty($config['t4web-admin'][$module][$entity]['list']['table']['head'])) {
                    $headConfig = $config['t4web-admin'][$module][$entity]['list']['table']['head'];

                    $tableHeadView = new T4webAdmin\View\Model\TableHeadViewModel();
                    $tableHeadView->setTemplate('t4web-admin/list-table-head');
                    $tableHeadView->setVariables($tableViewModel->getVariables());

                    foreach ($headConfig as $head) {
                        $tableHeadColumnView = new T4webAdmin\View\Model\TableHeadColumnViewModel();
                        $tableHeadColumnView->setTemplate('t4web-admin/list-table-head-column');
                        $tableHeadColumnView->setVariables($tableViewModel->getVariables());
                        $tableHeadColumnView->setValue($head);

                        $tableHeadView->addColumnView($tableHeadColumnView);
                    }

                    $tableViewModel->setHeadView($tableHeadView);
                }

                // row
                if (!empty($config['t4web-admin'][$module][$entity]['list']['table']['row'])) {
                    $rowConfig = $config['t4web-admin'][$module][$entity]['list']['table']['row'];

                    $tableRowView = new T4webAdmin\View\Model\TableRowViewModel();
                    $tableRowView->setTemplate('t4web-admin/list-table-row');
                    $tableRowView->setVariables($tableViewModel->getVariables());

                    foreach ($rowConfig as $row) {
                        $tableColumnView = new T4webAdmin\View\Model\TableColumnViewModel();
                        $tableColumnView->setTemplate('t4web-admin/list-table-row-column');
                        $tableColumnView->setVariables($tableRowView->getVariables());
                        $tableColumnView->setEntityAttribute($row);

                        $tableRowView->addColumnView($tableColumnView);
                    }

                    $tableViewModel->setRowView($tableRowView);
                }


                $viewModel->addChild($filterViewModel, 'filter');
                $viewModel->addChild($paginatorViewModel, 'paginator', true);
                $viewModel->setTableViewModel($tableViewModel);

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
            'T4WebAdmin\RouteGenerator' => 'T4WebAdmin\RouteGeneratorFactory',
        ],
    ],
];