<?php

namespace T4webAdmin\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Sebaks\Crud\Controller\ListController;

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
        $moduleEntityNamespace = ucfirst($module) . "\\" . ucfirst($entity);

        $repository = $this->serviceLocator->get("$moduleEntityNamespace\\Infrastructure\\Repository");

        /** @var \T4webAdmin\Config $config */
        $config = $this->serviceLocator->get('T4webAdmin\Config');
        $options = $config->getOptions();
        $module = $config->getModule();
        $entity = $config->getEntity();
        $action = $config->getAction();

        $viewModel = $this->serviceLocator->get($options["$module-$entity"]['actions'][$action]['mainViewComponent']);
        $validator = null;
        if ($this->serviceLocator->has("Admin\\Validator\\$moduleEntityNamespace\\ListValidator")) {
            $validator = $this->serviceLocator->get("Admin\\Validator\\$moduleEntityNamespace\\ListValidator");
        }

        $instance = new ListController(
            $this->getQuery(),
            $repository,
            $viewModel,
            $validator
        );

        return $instance;
    }

    private function getQuery()
    {
        return $this->serviceLocator->get('request')->getQuery()->toArray();
    }
}