<?php

namespace T4webAdmin\View\Model;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BaseViewModelAbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return strpos($requestedName, 't4web-admin-view-model-') === 0;
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');
        $options = $config->getOptions();
        $module = $config->getModule();
        $entity = $config->getEntity();

        $template = $options[$module . '-' . $entity]['views'][$requestedName]['template'];
        $variables = $options[$module . '-' . $entity]['views'][$requestedName]['variables'];
        $children = [];
        if (!empty($options[$module . '-' . $entity]['views'][$requestedName]['child'])) {
            $children = $options[$module . '-' . $entity]['views'][$requestedName]['child'];
        }

        $viewModel = new \T4webAdmin\View\Model\BaseViewModel();
        $viewModel->setName($requestedName);
        $viewModel->setTemplate($template);
        $viewModel->setVariables($variables);


        foreach ($children as $child) {
            var_dump($child);
            /** @var \T4webAdmin\View\Model\BaseViewModel $childViewModel */
            $childViewModel = $serviceLocator->get($child);

            if (!empty($actionViewsOptions[$child]['variables'])) {
                $childViewModel->setVariables($actionViewsOptions[$child]['variables']);
            }

            $viewModel->pushChild($serviceLocator->get($child), $child);
        }

        return $viewModel;
    }
}
