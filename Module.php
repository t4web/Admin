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

            /** @var \T4webAdmin\View\Model\BaseViewModel $viewModel */
            //$viewModel = $e->getResult();
            /** @var \Zend\View\Renderer\PhpRenderer $renderer */
            $renderer = $e->getApplication()->getServiceManager()->get('viewrenderer');
            $renderer->setCanRenderTrees(true);


//            $requestedName = $viewModel->getName();
//
//            $serviceLocator = $e->getApplication()->getServiceManager();
//
//            /** @var Config $config */
//            $config = $serviceLocator->get('T4webAdmin\Config');
//            $options = $config->getOptions();
//            $module = $config->getModule();
//            $entity = $config->getEntity();
//            $action = $config->getAction();
//
//            $template = $options[$module . '-' . $entity]['views'][$requestedName]['template'];
//            $variables = $options[$module . '-' . $entity]['views'][$requestedName]['variables'];
//            $children = [];
//            if (!empty($options[$module . '-' . $entity]['views'][$requestedName]['child'])) {
//                $children = $options[$module . '-' . $entity]['views'][$requestedName]['child'];
//            }
//
//            $childViewModel = new \T4webAdmin\View\Model\BaseViewModel();
//            $childViewModel->setName($requestedName);
//            $childViewModel->setTemplate($template);
//            $childViewModel->setVariables($variables);
//
//            $actionViewsOptions = [];
//            if (!empty($options[$module . '-' . $entity]['actions'][$action]['views'])) {
//                $actionViewsOptions = $options[$module . '-' . $entity]['actions'][$action]['views'];
//            }
//
//            foreach ($children as $child) {
//                /** @var \T4webAdmin\View\Model\BaseViewModel $childViewModel */
//                $childViewModel = $serviceLocator->get($child);
//
//                if (!empty($actionViewsOptions[$child]['variables'])) {
//                    $childViewModel->setVariables($actionViewsOptions[$child]['variables']);
//                }
//
//                $viewModel->pushChild($serviceLocator->get($child), $child);
//            }

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