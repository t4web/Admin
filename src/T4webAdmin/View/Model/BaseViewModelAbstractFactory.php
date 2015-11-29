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
        $this->serviceLocator = $serviceLocator;

        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');
        $options = $config->getOptions();
        
        if (!isset($options['viewComponents'])) {
            return false;
        }
        
        $viewsConfig = $options['viewComponents'];

        if (!isset($viewsConfig[$requestedName])) {
            return false;
        }

        $viewConfig = $viewsConfig[$requestedName];

        return $this->createViewModel($options, $viewConfig, $requestedName);
    }

    private function createViewModel(array $options, array $viewConfig, $requestedName)
    {
        if (!empty($viewConfig['extend'])) {
            if (!isset($options['viewComponents'][$viewConfig['extend']])) {
                throw new \Exception("View component $requestedName extend $viewConfig[extend] but it's configuration not found");
            }

            $extendView = $options['viewComponents'][$viewConfig['extend']];

            $viewConfig = array_replace_recursive($extendView, $viewConfig);
        }

        if (empty($viewConfig['template'])) {
            throw new \Exception("Empty template for $requestedName");
        }

        $template = $viewConfig['template'];

        if (!empty($viewConfig['viewModel'])) {
            $viewModelClass = $viewConfig['viewModel'];
            $viewModel = $this->serviceLocator->get($viewModelClass);
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

            if (is_array($child)) {

                $childViewConfig = $child;

                $childViewModel = $this->createViewModel($options, $childViewConfig, $childAlias);

                if (!$childViewModel) {
                    throw new \Exception("Cannot create child view '$child' for '$requestedName' view");
                }

                $viewModel->pushChild($childViewModel, $childAlias);

            } elseif (is_string($child)) {

                if (is_int($childAlias)) {
                    $childAlias = $child;
                }

                $childViewModel = $this->serviceLocator->get($child);

                if (!$childViewModel) {
                    throw new \Exception("Cannot create child view '$child' for '$requestedName' view");
                }

                $viewModel->pushChild($childViewModel, $childAlias);

            } else {
                throw new \Exception("Wrong child configuration for view $requestedName. It must be string or array.");
            }
        }

        return $viewModel;
    }
}
