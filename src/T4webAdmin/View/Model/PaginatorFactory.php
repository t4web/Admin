<?php

namespace T4webAdmin\View\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Http\PhpEnvironment\Request;
use T4webFilter\Filter;

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

        $repository = $serviceLocator->get(ucfirst($module) . "\\" . ucfirst($entity) . "\\Infrastructure\\Repository");

        $filter = new Filter();

        return new PaginatorViewModel(
            $repository,
            $filter->prepare($request->getQuery()->toArray())
        );
    }
}