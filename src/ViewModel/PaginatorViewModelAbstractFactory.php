<?php

namespace T4web\Admin\ViewModel;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PaginatorViewModelAbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $namespaceParts = explode('\\', $requestedName);
        return count($namespaceParts) == 4
        && $namespaceParts[2] == 'ViewModel'
        && $namespaceParts[3] == 'PaginatorViewModel';
    }
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $namespaceParts = explode('\\', $requestedName);
        $module = $namespaceParts[0];
        $entity = $namespaceParts[1];

        if ($serviceLocator->has(ucfirst($entity) . "\\Infrastructure\\Repository")) {
            $repository = $serviceLocator->get(ucfirst($entity) . "\\Infrastructure\\Repository");
        } else {
            $moduleEntityNamespace = ucfirst($module) . "\\" . ucfirst($entity);
            $repository = $serviceLocator->get($moduleEntityNamespace . "\\Infrastructure\\Repository");
        }

        return new PaginatorViewModel($repository);
    }
}
