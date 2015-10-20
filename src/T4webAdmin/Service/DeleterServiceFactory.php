<?php

namespace T4webAdmin\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManager;
use T4webAdmin\Config;
use T4webBase\Domain\Service\Delete as Deleter;

class DeleterServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');

        $umodule = ucfirst($config->getModule());
        $uentity = ucfirst($config->getEntity());

        $repository = $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository");
        $criteriaFactory = $serviceLocator->get("$umodule\\$uentity\Criteria\CriteriaFactory");

        /** @var EventManager $eventManager */
        $eventManager = $serviceLocator->get('EventManager');
        $eventManager->addIdentifiers("$umodule\\$uentity\Service\Deleter");

        $deleter = new Deleter($repository, $criteriaFactory, $eventManager);

        return $deleter;
    }
}