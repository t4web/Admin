<?php

namespace T4webAdmin\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Sebaks\Crud\Controller\CreateController;
use T4webDomainInterface\Infrastructure\RepositoryInterface;
use T4webAdmin\View\Model\ListViewModel;
use T4webAdmin\View\Model\PaginatorViewModel;
use T4webAdmin\View\Model\ReadViewModel;
use T4webAdmin\Config;

class ReadControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();
        /** @var T4webAdmin\Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');

        $post = $serviceLocator->get('request')->getPost()->toArray();

        $routeMatch = $serviceLocator->get('Application')->getMvcEvent()->getRouteMatch();

        $module = $routeMatch->getParam('module');
        $entity = $routeMatch->getParam('entity');

        /** @var RepositoryInterface $repository */
        $repository = $serviceLocator->get("$module\\$entity\\Service\\Creator");

        $creator = $serviceLocator->get('T4webAdmin\Service\CreatorService');

        $viewModel = $serviceLocator->get($config->getActionViewModel());
        $redirectTo = $config->getActionRedirect();

        return new CreateController($post, $creator, $viewModel, $redirectTo);
    }
}