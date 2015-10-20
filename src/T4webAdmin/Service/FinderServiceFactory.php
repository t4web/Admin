<?php

namespace T4webAdmin\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4webAdmin\Config;
use T4webBase\Domain\Service\BaseFinder;

class FinderServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');

        $umodule = ucfirst($config->getModule());
        $uentity = ucfirst($config->getEntity());

        $repository = $serviceLocator->get("$umodule\\$uentity\Repository\DbRepository");
        $criteriaFactory = $serviceLocator->get("$umodule\\$uentity\Criteria\CriteriaFactory");
        $finder = new BaseFinder($repository, $criteriaFactory);

        return $finder;
    }
}