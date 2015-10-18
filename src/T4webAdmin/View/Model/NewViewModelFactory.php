<?php

namespace T4webAdmin\View\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NewViewModelFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \T4webAdmin\Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');

        $viewModel = new NewViewModel();
        $viewModel->setTemplate($config->getNewViewModelTemplate());
        $viewModel->setVariable('title', $config->getNewViewModelTitle());

        /** @var FormViewModel $formViewModel */
        $formViewModel = $serviceLocator->get('T4webAdmin\View\Model\FormViewModel');
        $viewModel->setFormViewModel($formViewModel);

        return $viewModel;
    }
}