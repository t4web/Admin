<?php

namespace T4webAdmin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;
use Zend\Console\Request as ConsoleRequest;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, BootstrapListenerInterface
{
    public function onBootstrap(EventInterface $e)
    {
        if ($e->getRequest() instanceof ConsoleRequest) {
            return;
        }

        /** @var \Zend\EventManager\EventManager $eventManager */
        $eventManager = $e->getApplication()->getEventManager();

        $eventManager->attach(MvcEvent::EVENT_ROUTE, function(EventInterface $e) {
            $serviceManager = $e->getApplication()->getServiceManager();
            $routeGenerator = $serviceManager->get('T4WebAdmin\RouteGenerator');
            $routeGenerator->generate();
        }, 1000);

        $eventManager->attach(MvcEvent::EVENT_RENDER, function(\Zend\Mvc\MvcEvent $e) {
            $routeMatch = $e->getRouteMatch();
            if (!$routeMatch) {
                return;
            }

            if (strpos($matchedRoute, 'admin-') !== false) {
                /** @var \Zend\View\Renderer\PhpRenderer $renderer */
                $renderer = $e->getApplication()->getServiceManager()->get('viewrenderer');
                $renderer->setCanRenderTrees(true);
            }
        }, 10000);
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