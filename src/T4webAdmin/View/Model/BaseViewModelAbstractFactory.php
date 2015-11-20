<?php

namespace T4webAdmin\View\Model;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BaseViewModelAbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return strpos($requestedName, '-view-component-') !== false;
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');
        $options = $config->getOptions();
        $module = $config->getModule();
        $entity = $config->getEntity();
        $action = $config->getAction();

        if (empty($options[$module . '-' . $entity]['viewComponents'][$requestedName]['template'])) {
            throw new \Exception("Empty template for $requestedName");
        }

        $template = $options[$module . '-' . $entity]['viewComponents'][$requestedName]['template'];

        $variables = [];
        if (!empty($options[$module . '-' . $entity]['viewComponents'][$requestedName]['variables'])) {
            $variables = $options[$module . '-' . $entity]['viewComponents'][$requestedName]['variables'];
        }
        if (!empty($options[$module . '-' . $entity]['actions'][$action]['viewComponents'][$requestedName]['variables'])) {
            $variables = array_merge($variables, $options[$module . '-' . $entity]['actions'][$action]['viewComponents'][$requestedName]['variables']);
        }

        $children = [];
        if (!empty($options[$module . '-' . $entity]['viewComponents'][$requestedName]['children'])) {
            $children = $options[$module . '-' . $entity]['viewComponents'][$requestedName]['children'];
        }

        if (!empty($options[$module . '-' . $entity]['viewComponents'][$requestedName]['viewModel'])) {
            $viewModelClass = $options[$module . '-' . $entity]['viewComponents'][$requestedName]['viewModel'];
            $viewModel = $serviceLocator->get($viewModelClass);
        } else {
            $viewModel = new BaseViewModel();
        }

        $viewModel->setName($requestedName);
        $viewModel->setTemplate($template);
        $viewModel->setVariables($variables);

        foreach ($children as $childAlias => $child) {
            if (!is_string($childAlias)) {
                $childAlias = $child;
            }

            /** @var \T4webAdmin\View\Model\BaseViewModel $childViewModel */
            $childViewModel = $serviceLocator->get($child);

            $viewModel->pushChild($childViewModel, $childAlias);
        }

        return $viewModel;
    }
}
