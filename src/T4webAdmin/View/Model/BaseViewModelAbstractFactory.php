<?php

namespace T4webAdmin\View\Model;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4webAdmin\Config;

class BaseViewModelAbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return strpos($requestedName, '-admin-view-component-') !== false;
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');
        $options = $config->getOptions();
        $action = $config->getAction();

        if (empty($options['viewComponents'][$requestedName]['template'])) {
            throw new \Exception("Empty template for $requestedName");
        }

        $template = $options['viewComponents'][$requestedName]['template'];

        $variables = [];
        if (!empty($options['viewComponents'][$requestedName]['variables'])) {
            $variables = $options['viewComponents'][$requestedName]['variables'];
        }
        if (!empty($options['actions'][$action]['viewComponents'][$requestedName]['variables'])) {
            $variables = array_merge($variables, $options['actions'][$action]['viewComponents'][$requestedName]['variables']);
        }

        $children = [];
        if (!empty($options['viewComponents'][$requestedName]['children'])) {
            $children = $options['viewComponents'][$requestedName]['children'];
        }

        if (!empty($options['viewComponents'][$requestedName]['viewModel'])) {
            $viewModelClass = $options['viewComponents'][$requestedName]['viewModel'];
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
