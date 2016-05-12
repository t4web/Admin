<?php

namespace T4web\Admin\ViewModel;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Router\RouteMatch;
use Zend\View\Model\ViewModel;

class SidebarItemsViewModelFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var RouteMatch $routeMatch */
        $routeMatch = $serviceLocator->get('Application')->getMvcEvent()->getRouteMatch();

        /** @var \Zend\Http\PhpEnvironment\Request $r */
        $uriService = $serviceLocator->get('Application')->getRequest();
        $requestUri = $uriService->getUri()->getPath();

        $currentRoute = $routeMatch ? $routeMatch->getMatchedRouteName() : null;

        return new ViewModel(['currentRoute' => $currentRoute,
            'requestUri' => $requestUri
        ]);
    }
}
