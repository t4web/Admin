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

        if (!isset($options['viewComponents'][$requestedName])) {
            return false;
        }

        $viewConfig = $options['viewComponents'][$requestedName];

        if (empty($viewConfig['template'])) {
            throw new \Exception("Empty template for $requestedName");
        }

        $template = $viewConfig['template'];

        if (!empty($viewConfig['viewModel'])) {
            $viewModelClass = $viewConfig['viewModel'];
            $viewModel = $serviceLocator->get($viewModelClass);
        } else {
            $viewModel = new BaseViewModel();
        }

        $variables = [];
        if (!empty($viewConfig['variables'])) {
            $variables = $viewConfig['variables'];
        }

        $children = [];
        if (!empty($viewConfig['children'])) {
            $children = $viewConfig['children'];
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
