<?php

namespace T4webAdmin\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManager;
use Zend\InputFilter\Factory as InputFilterFactory;
use T4webAdmin\Config;
use T4webBase\Domain\Service\Update as Updater;

class UpdaterServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');

        $inputFilterFactory = new InputFilterFactory();
        $inputFilter = $inputFilterFactory->createInputFilter($config->getValidation());

        $umodule = ucfirst($config->getModule());
        $uentity = ucfirst($config->getEntity());

        /** @var EventManager $eventManager */
        $eventManager = $serviceLocator->get('EventManager');
        $eventManager->addIdentifiers("$umodule\\$uentity\Service\Updater");

        $updater = new Updater(
            $inputFilter,
            $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository"),
            $serviceLocator->get("$umodule\\$uentity\Factory\CriteriaFactory"),
            $eventManager
        );

        return $updater;
    }
}