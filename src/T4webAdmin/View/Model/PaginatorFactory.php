<?php

namespace T4webAdmin\View\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Http\PhpEnvironment\Request;

class PaginatorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $app = $serviceLocator->get('Application');
        /** @var RouteMatch $routeMatch */
        $routeMatch = $app->getMvcEvent()->getRouteMatch();

        $module = $routeMatch->getParam('module');
        $entity = $routeMatch->getParam('entity');
        /** @var Request $request */
        $request = $app->getMvcEvent()->getRequest();

        $moduleEntityNamespace = ucfirst($module) . "\\" . ucfirst($entity);

        $repository = $serviceLocator->get($moduleEntityNamespace . "\\Infrastructure\\Repository");

        $validator = null;
        if ($serviceLocator->has("Admin\\Validator\\$moduleEntityNamespace\\ListValidator")) {
            $validator = $serviceLocator->get("Admin\\Validator\\$moduleEntityNamespace\\ListValidator");
        }

        return new PaginatorViewModel(
            $repository,
            $request->getQuery()->toArray(),
            $validator
        );
    }
}
