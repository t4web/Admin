<?php

namespace T4webAdmin;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventInterface;
use Zend\Mvc\Router\Http\Segment;

class RouteListener extends AbstractListenerAggregate
{
    /**
     * Attach to an event manager
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'onRoute']);
    }

    /**
     * @param  EventInterface $e
     * @return void
     */
    public function onRoute(EventInterface $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();

        $config = $serviceManager->get('config');

        if (!isset($config['t4web-admin'])) {
            return;
        }

        foreach ($config['t4web-admin'] as $module => $moduleConfig) {
            foreach ($moduleConfig['entities'] as $entity) {
                /** @var \Zend\Mvc\Router\Http\TreeRouteStack $router */
                $router = $e->getRouter();

                $route = Segment::factory(array(
                    'route' => '/admin/' . $module . '/' . $entity . '[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'T4webAdmin\Controller',
                        'controller' => 'List',
                        'action' => 'list',
                        'module' => $module,
                        'entity' => $entity,
                    )
                ));

                $router->addRoute('admin-' . $module . '-' . $entity, $route);
            }
        }
    }
}
