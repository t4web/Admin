<?php

namespace T4webAdmin\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4webAdmin\Config;

class CreatorServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');

        $inputFilterFactory = new \Zend\InputFilter\Factory();
        $inputFilter = $inputFilterFactory->createInputFilter($config->getValidation());

        $umodule = ucfirst($config->getModule());
        $uentity = ucfirst($config->getEntity());

        /** @var \Zend\EventManager\EventManager $eventManager */
        $eventManager = $serviceLocator->get('EventManager');
        $eventManager->addIdentifiers("$umodule\\$uentity\Service\Creator");

        $creator = new \T4webBase\Domain\Service\NewCreate(
            $inputFilter,
            $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository"),
            $serviceLocator->get("$umodule\\$uentity\Factory\EntityFactory"),
            $eventManager
        );

        return $creator;
    }
}