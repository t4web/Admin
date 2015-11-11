<?php

namespace T4webAdmin\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Sebaks\Crud\Controller\ListController;
use T4webAdmin\InputFilter\ListInputFilter;
use T4webAdmin\View\Model\ListViewModel;
use T4webAdmin\View\Model\ListFilterViewModel;
use T4webAdmin\View\Model\PaginatorViewModel;
use T4webAdmin\View\Model\TableViewModel;
use T4webAdmin\View\Model\TableHeadViewModel;
use T4webAdmin\View\Model\TableHeadColumnViewModel;
use T4webAdmin\View\Model\TableRowViewModel;
use T4webAdmin\View\Model\TableColumnViewModel;
use T4webFilter\Filter;

class ListControllerFactory implements FactoryInterface
{
    /**
     * @var ServiceManager
     */
    private $serviceLocator;

    /**
     * @var ListInputFilter
     */
    private $inputFilter;

    private $module;
    private $entity;

    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $this->serviceLocator = $controllerManager->getServiceLocator();
        /** @var \Zend\Mvc\Application $app */
        $app = $this->serviceLocator->get('Application');
        /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
        $routeMatch = $app->getMvcEvent()->getRouteMatch();

        $module = $this->module = $routeMatch->getParam('module');
        $entity = $this->entity = $routeMatch->getParam('entity');

        // View
        $viewModel = new ListViewModel();
        $viewModel->setTemplate('t4web-admin/list');
        $viewModel->setVariable('route', "admin-$module-$entity-list");

        // FilterView
        $filterViewModel = new ListFilterViewModel($this->getInputFilter());
        $filterViewModel->setTemplate('t4web-admin/list-filter');

        $repository = $this->serviceLocator->get(ucfirst($module) . "\\" . ucfirst($entity) . "\\Infrastructure\\Repository");

        // PaginatorView
        $paginatorViewModel = new PaginatorViewModel($this->getInputFilter(), $repository);
        $paginatorViewModel->setTemplate('t4web-admin/paginator');

        $viewModel->addChild($filterViewModel, 'filter');
        $viewModel->addChild($paginatorViewModel, 'paginator', true);
        $viewModel->setTableViewModel($this->getTableView($viewModel));

        $instance = new ListController(
            $this->getQuery(),
            new Filter(),
            $repository,
            $viewModel
        );

        return $instance;
    }

    private function getQuery()
    {
        return $this->serviceLocator->get('request')->getQuery()->toArray();
    }

    private function getInputFilter()
    {
        if (is_null($this->inputFilter)) {
            $this->inputFilter = new ListInputFilter(ucfirst($this->module), ucfirst($this->entity));
        }

        return $this->inputFilter;
    }
/*
    private function getFinder()
    {
        if (is_null($this->finder)) {
            $umodule = ucfirst($this->module);
            $uentity = ucfirst($this->entity);
            $repository = $this->serviceLocator->get("$umodule\\$uentity\Repository\DbRepository");
            $criteriaFactory = $this->serviceLocator->get("$umodule\\$uentity\Criteria\CriteriaFactory");
            $this->finder = new BaseFinder($repository, $criteriaFactory);
        }

        return $this->finder;
    }
*/
    private function getTableView($parentViewModel)
    {
        // TableView
        $tableViewModel = new TableViewModel();
        $tableViewModel->setTemplate('t4web-admin/list-table');
        $tableViewModel->setVariables($parentViewModel->getVariables());


        // head
        $config = $this->serviceLocator->get('config');

        if (!empty($config['t4web-admin'][$this->module][$this->entity]['list']['table']['head'])) {
            $headConfig = $config['t4web-admin'][$this->module][$this->entity]['list']['table']['head'];

            $tableHeadView = new TableHeadViewModel();
            $tableHeadView->setTemplate('t4web-admin/list-table-head');
            $tableHeadView->setVariables($tableViewModel->getVariables());

            foreach ($headConfig as $head) {
                $tableHeadColumnView = new TableHeadColumnViewModel();
                $tableHeadColumnView->setTemplate('t4web-admin/list-table-head-column');
                $tableHeadColumnView->setVariables($tableViewModel->getVariables());
                $tableHeadColumnView->setValue($head);

                $tableHeadView->addColumnView($tableHeadColumnView);
            }

            $tableViewModel->setHeadView($tableHeadView);
        }

        // row
        if (!empty($config['t4web-admin'][$this->module][$this->entity]['list']['table']['row'])) {
            $rowConfig = $config['t4web-admin'][$this->module][$this->entity]['list']['table']['row'];

            $tableRowView = new TableRowViewModel();
            $tableRowView->setTemplate('t4web-admin/list-table-row');
            $tableRowView->setVariables($tableViewModel->getVariables());

            foreach ($rowConfig as $row) {
                $tableColumnView = new TableColumnViewModel();
                $tableColumnView->setTemplate('t4web-admin/list-table-row-column');
                $tableColumnView->setVariables($tableRowView->getVariables());
                $tableColumnView->setEntityAttribute($row);

                $tableRowView->addColumnView($tableColumnView);
            }

            $tableViewModel->setRowView($tableRowView);
        }

        return $tableViewModel;
    }
}