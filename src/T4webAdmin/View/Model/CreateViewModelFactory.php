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
        $viewModel->setTemplate($config->getCreateViewModelTemplate());
        $viewModel->setVariable('title', $config->getCreateViewModelTitle());

        /** @var FormViewModel $formViewModel */
        $formViewModel = $serviceLocator->get('T4webAdmin\View\Model\FormViewModel');
        $formViewModel->setVariable('controller', $config->getCreateViewController());
        $formViewModel->setVariable('submitText', $config->getCreateViewSubmitText());
        $viewModel->setFormViewModel($formViewModel);

        return $viewModel;
    }
}