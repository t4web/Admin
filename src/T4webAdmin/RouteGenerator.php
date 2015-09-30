<?php

namespace T4webAdmin;

use Zend\Mvc\Router\Http\Segment;
use Zend\Mvc\MvcEvent;

class RouteGenerator
{
    /**
     * @var MvcEvent
     */
    private $event;

    /**
     * @var array
     */
    private $config;

    /**
     * @param MvcEvent $event
     * @param array $config
     */
    public function __construct(MvcEvent $event, array $config)
    {
        $this->event = $event;
        $this->config = $config;
    }

    /**
     * @return void
     */
    public function generate()
    {
        if (!isset($this->config['t4web-admin'])) {
            return;
        }

        /** @var \Zend\Mvc\Router\Http\TreeRouteStack $router */
        $router = $this->event->getRouter();

        foreach ($this->config['t4web-admin'] as $module => $moduleConfig) {
            foreach ($moduleConfig['entities'] as $entity) {
                $route = Segment::factory(array(
                    'route' => "/admin/{$module}/{$entity}[/:action][/:id]",
                    'defaults' => array(
                        '__NAMESPACE__' => 'T4webAdmin\Controller',
                        'controller' => 'List',
                        'action' => 'list',
                        'module' => $module,
                        'entity' => $entity,
                    )
                ));

                $router->addRoute("admin-$module-$entity", $route);
            }
        }
    }
}
