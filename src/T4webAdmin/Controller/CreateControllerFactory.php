<?php

namespace T4webAdmin\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Sebaks\Crud\Controller\CreateController;
use T4webDomainInterface\Service\CreatorInterface;
use T4webAdmin\View\Model\ListViewModel;
use T4webAdmin\View\Model\PaginatorViewModel;
use T4webAdmin\View\Model\ReadViewModel;
use T4webAdmin\Config;

class CreateControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();
        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');
        $options = $config->getOptions();
        $action = $config->getAction();

        $post = $serviceLocator->get('request')->getPost()->toArray();

        $routeMatch = $serviceLocator->get('Application')->getMvcEvent()->getRouteMatch();

        $module = $routeMatch->getParam('module');
        $entity = $routeMatch->getParam('entity');

        $viewModel = $serviceLocator->get($options["$module-$entity"]['actions'][$action]['mainViewComponent']);
        $viewModel->setName('t4web-admin-view-model-read');
        $redirectTo = $config->getActionRedirect();

        $module = ucfirst($module);
        $entity = ucfirst($entity);

        /** @var CreatorInterface $repository */
        $creator = $serviceLocator->get("$module\\$entity\\Service\\Creator");

        return new CreateController($post, $creator, $viewModel, $redirectTo);
    }
}