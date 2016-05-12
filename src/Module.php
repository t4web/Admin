<?php

namespace T4web\Admin;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\Exception\MissingDependencyModuleException;

class Module implements ConfigProviderInterface, BootstrapListenerInterface
{
    public function onBootstrap(EventInterface $e)
    {
        /** @var ModuleManager $moduleManager */
        $moduleManager = $e->getApplication()
            ->getServiceManager()
            ->get('modulemanager');
        if (!$moduleManager->getModule('Sebaks\View')) {
            throw new MissingDependencyModuleException('Module "Sebaks\View" must be enabled in your
                config/application.config.php. For details see https://github.com/t4web/Admin#post-installation.');
        }
        if (!$moduleManager->getModule('Sebaks\ZendMvcController')) {
            throw new MissingDependencyModuleException('Module "Sebaks\ZendMvcController" must be enabled in your
                config/application.config.php. For details see https://github.com/t4web/Admin#post-installation.');
        }
    }

    public function getConfig()
    {
        return include dirname(__DIR__) . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    'T4web\Admin' => dirname(__DIR__) . '/src',
                ),
            ),
        );
    }
}
