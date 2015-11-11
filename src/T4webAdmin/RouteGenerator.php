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
        $config = $this->config['t4web-admin'];

        foreach ($config as $entityConfig) {

            $module = $entityConfig['module'];
            $entity = $entityConfig['entity'];

//            $route = Segment::factory([
//                'route' => '/admin/' . $module . '/' . $entity . '[/:action]/:id',
//                'defaults' => [
//                    '__NAMESPACE__' => 'T4webAdmin\Controller',
//                    'controller' => 'list',
//                    'action' => 'index',
//                    'module' => $module,
//                    'entity' => $entity,
//                ],
//                'constraints' => [
//                    'controller' => 'create|read'
//                ],
//            ]);
//
//            $router->addRoute('admin-' . $module . '-' . $entity . '-new', $route);
            if (empty($entityConfig['actions']['new']['disable'])) {

                $route = Segment::factory(array(
                    'route' => '/admin/' . $module . '/' . $entity . '/new',
                    'defaults' => array(
                        '__NAMESPACE__' => 'T4webAdmin\Controller',
                        'controller' => 'new',
                        'action' => 'index',
                        'module' => $module,
                        'entity' => $entity,
                    )
                ));

                $router->addRoute('admin-' . $module . '-' . $entity . '-new', $route);
            }

            if (empty($entityConfig['actions']['create']['disable'])) {

                $route = Segment::factory(array(
                    'route' => '/admin/' . $module . '/' . $entity . '/create',
                    'defaults' => array(
                        '__NAMESPACE__' => 'T4webAdmin\Controller',
                        'controller' => 'create',
                        'action' => 'index',
                        'module' => $module,
                        'entity' => $entity,
                    )
                ));

                $router->addRoute('admin-' . $module . '-' . $entity . '-create', $route);
            }

            if (empty($entityConfig['actions']['read']['disable'])) {

                $route = Segment::factory(array(
                    'route' => '/admin/' . $module . '/' . $entity . '/read/:id',
                    'defaults' => array(
                        '__NAMESPACE__' => 'T4webAdmin\Controller',
                        'controller' => 'read',
                        'action' => 'index',
                        'module' => $module,
                        'entity' => $entity,
                    )
                ));

                $router->addRoute('admin-' . $module . '-' . $entity . '-read', $route);
            }

            if (empty($entityConfig['actions']['update']['disable'])) {

                $route = Segment::factory(array(
                    'route' => '/admin/' . $module . '/' . $entity . '/update/:id',
                    'defaults' => array(
                        '__NAMESPACE__' => 'T4webAdmin\Controller',
                        'controller' => 'update',
                        'action' => 'index',
                        'module' => $module,
                        'entity' => $entity,
                    )
                ));

                $router->addRoute('admin-' . $module . '-' . $entity . '-update', $route);
            }

            if (empty($entityConfig['actions']['list']['disable'])) {

                $route = Segment::factory(array(
                    'route' => '/admin/' . $module . '/' . $entity . '/list',
                    'defaults' => array(
                        '__NAMESPACE__' => 'T4webAdmin\Controller',
                        'controller' => 'list',
                        'action' => 'index',
                        'module' => $module,
                        'entity' => $entity,
                    )
                ));

                $router->addRoute('admin-' . $module . '-' . $entity . '-list', $route);
            }
        }


    }
}
