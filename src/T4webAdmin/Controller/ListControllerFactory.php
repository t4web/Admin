<?php

namespace T4webAdmin\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use T4webAdmin\InputFilter\ListInputFilter;
use T4webBase\Domain\Service\BaseFinder;

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

    /**
     * @var BaseFinder
     */
    private $finder;

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
        $viewModel = new \T4webAdmin\View\Model\ListViewModel();
        $viewModel->setTemplate('t4web-admin/list');
        $viewModel->setVariable('route', 'admin-' . $module . '-' . $entity);

        // FilterView
        $filterViewModel = new \T4webAdmin\View\Model\ListFilterViewModel($this->getInputFilter());
        $filterViewModel->setTemplate('t4web-admin/list-filter');

        // PaginatorView
        $paginatorViewModel = new \T4webAdmin\View\Model\PaginatorViewModel($this->getInputFilter(), $this->getFinder());
        $paginatorViewModel->setTemplate('t4web-admin/paginator');

        $viewModel->addChild($filterViewModel, 'filter');
        $viewModel->addChild($paginatorViewModel, 'paginator', true);
        $viewModel->setTableViewModel($this->getTableView($viewModel));

        $instance = new \Sebaks\Crud\Controller\ListController(
            $this->getQuery(),
            $this->getInputFilter(),
            $this->getFinder(),
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

    private function getFinder()
    {
        if (is_null($this->finder)) {
            $umodule = ucfirst($this->module);
            $uentity = ucfirst($this->entity);
            $repository = $this->serviceLocator->get("$umodule\\$uentity\Repository\DbRepository");
            $criteriaFactory = $this->serviceLocator->get("$umodule\\$uentity\Criteria\CriteriaFactory");
            $this->finder = new \T4webBase\Domain\Service\BaseFinder($repository, $criteriaFactory);
        }

        return $this->finder;
    }

    private function getTableView($parentViewModel)
    {
        // TableView
        $tableViewModel = new \T4webAdmin\View\Model\TableViewModel();
        $tableViewModel->setTemplate('t4web-admin/list-table');
        $tableViewModel->setVariables($parentViewModel->getVariables());


        // head
        $config = $this->serviceLocator->get('config');

        if (!empty($config['t4web-admin'][$this->module][$this->entity]['list']['table']['head'])) {
            $headConfig = $config['t4web-admin'][$this->module][$this->entity]['list']['table']['head'];

            $tableHeadView = new \T4webAdmin\View\Model\TableHeadViewModel();
            $tableHeadView->setTemplate('t4web-admin/list-table-head');
            $tableHeadView->setVariables($tableViewModel->getVariables());

            foreach ($headConfig as $head) {
                $tableHeadColumnView = new \T4webAdmin\View\Model\TableHeadColumnViewModel();
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

            $tableRowView = new \T4webAdmin\View\Model\TableRowViewModel();
            $tableRowView->setTemplate('t4web-admin/list-table-row');
            $tableRowView->setVariables($tableViewModel->getVariables());

            foreach ($rowConfig as $row) {
                $tableColumnView = new \T4webAdmin\View\Model\TableColumnViewModel();
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