<?php

namespace T4webAdmin;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConfigFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Zend\Mvc\Application $app */
        $app = $serviceLocator->get('Application');
        /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
        $routeMatch = $app->getMvcEvent()->getRouteMatch();

        $module = $routeMatch->getParam('module');
        $entity = $routeMatch->getParam('entity');
        $action = $routeMatch->getParam('__CONTROLLER__');

        $options = [];
        if ($serviceLocator->has('config')) {
            $config = $serviceLocator->get('config');

            if (!empty($config['t4web-admin'])) {
                $options = $config['t4web-admin'];
            }
        }

        $config = new Config($options);
        $config->setModule($module);
        $config->setEntity($entity);
        $config->setAction($action);

        return $config;
    }
}