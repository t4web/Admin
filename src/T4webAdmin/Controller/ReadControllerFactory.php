<?php

namespace T4webAdmin\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Sebaks\Crud\Controller\ReadController;
use T4webDomainInterface\Infrastructure\RepositoryInterface;
use T4webInfrastructure\Criteria;
use T4webAdmin\Config;

class ReadControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var ServiceManager $serviceLocator */
        $serviceLocator = $controllerManager->getServiceLocator();

        $routeMatch = $serviceLocator->get('Application')->getMvcEvent()->getRouteMatch();

        $module = $routeMatch->getParam('module');
        $entity = $routeMatch->getParam('entity');

        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');
        $options = $config->getOptions();
        $action = $config->getAction();

        $viewModel = $serviceLocator->get($options["$module-$entity"]['actions'][$action]['mainViewComponent']);
        $viewModel->setName('t4web-admin-view-model-read');
        $viewModel->setTemplate('t4web-admin/entity-manage');

        $module = ucfirst($module);
        $entity = ucfirst($entity);

        /** @var RepositoryInterface $repository */
        $repository = $serviceLocator->get("$module\\$entity\\Infrastructure\\Repository");

        $criteria = new Criteria($entity);
        $criteria->equalTo('id', $routeMatch->getParam('id'));

        return new ReadController($criteria, $repository, $viewModel);
    }
}