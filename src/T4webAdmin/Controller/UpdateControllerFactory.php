<?php

namespace T4webAdmin\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Sebaks\Crud\Controller\UpdateController;
use T4webDomainInterface\Service\UpdaterInterface;
use T4webAdmin\Config;

class UpdateControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();
        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');
        $options = $config->getOptions();
        $action = $config->getAction();

        /** @var \Zend\Mvc\Application $app */
        $app = $serviceLocator->get('Application');

        /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
        $routeMatch = $app->getMvcEvent()->getRouteMatch();

        $module = $routeMatch->getParam('module');
        $entity = $routeMatch->getParam('entity');

        $id = $routeMatch->getParam('id');
        $post = $serviceLocator->get('request')->getPost()->toArray();

        $viewModel = $serviceLocator->get($options["$module-$entity"]['actions'][$action]['mainViewComponent']);
        $viewModel->setName('t4web-admin-view-model-update');
        $redirectToRoute = $config->getActionRedirect();

        $module = ucfirst($module);
        $entity = ucfirst($entity);

        /** @var UpdaterInterface $repository */
        $updater = $serviceLocator->get("$module\\$entity\\Service\\Updater");

        return new UpdateController($id, $post, $updater, $viewModel, $redirectToRoute);
    }
}