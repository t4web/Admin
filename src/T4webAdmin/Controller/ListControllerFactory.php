<?php

namespace T4webAdmin\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Sebaks\Crud\Controller\ListController;
use T4webAdmin\View\Model\ListViewModel;
//use T4webAdmin\View\Model\PaginatorViewModel;
use T4webFilter\Filter;

class ListControllerFactory implements FactoryInterface
{
    /**
     * @var ServiceManager
     */
    private $serviceLocator;

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

        $repository = $this->serviceLocator->get(ucfirst($module) . "\\" . ucfirst($entity) . "\\Infrastructure\\Repository");

        /** @var \T4webAdmin\Config $config */
        $config = $this->serviceLocator->get('T4webAdmin\Config');
        $options = $config->getOptions();
        $module = $config->getModule();
        $entity = $config->getEntity();
        $action = $config->getAction();

        $viewModel = $this->serviceLocator->get($options["$module-$entity"]['actions'][$action]['mainViewComponent']);


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
}