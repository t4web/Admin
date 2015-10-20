<?php

namespace T4webAdmin\View\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4webAdmin\Config;

class CreateViewModelFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');

        $viewModel = new CreateViewModel();
        $viewModel->setTemplate($config->getTemplate());
        $viewModel->setVariable('title', $config->getTitle());

        /** @var FormViewModel $formViewModel */
        $formViewModel = $serviceLocator->get('T4webAdmin\View\Model\FormViewModel');
        $viewModel->setFormViewModel($formViewModel);

        return $viewModel;
    }
}