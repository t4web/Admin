<?php

namespace T4webAdmin;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RouteGeneratorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $event = $serviceManager->get('Application')->getMvcEvent();
        $config = $serviceManager->get('config');

        return new RouteGenerator($event, $config);
    }
}