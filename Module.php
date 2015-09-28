<?php

namespace T4webAdmin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\Segment;
use Zend\Console\Request as ConsoleRequest;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        if ($e->getRequest() instanceof ConsoleRequest) {
            return;
        }

        $eventManager = $e->getApplication()->getEventManager();

        $eventManager->attach(MvcEvent::EVENT_ROUTE, function(MvcEvent $e) {
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
        }, 1000);
    }

    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}