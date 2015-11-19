<?php

namespace T4webAdmin\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4webAdmin\View\Model\ListViewModel;
use T4webAdmin\View\Model\PaginatorViewModel;
use T4webAdmin\View\Model\ReadViewModel;
use T4webAdmin\Config;

class NewControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();

        $routeMatch = $serviceLocator->get('Application')->getMvcEvent()->getRouteMatch();

        $module = $routeMatch->getParam('module');
        $entity = $routeMatch->getParam('entity');

        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');
        $options = $config->getOptions();
        $action = $config->getAction();

        $viewModel = $serviceLocator->get($options["$module-$entity"]['actions'][$action]['mainViewComponent']);

        return new NewController($viewModel);
    }
}