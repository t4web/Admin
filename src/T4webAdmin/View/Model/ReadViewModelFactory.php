<?php

namespace T4webAdmin\View\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4webAdmin\Config;

class ReadViewModelFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');

        $viewModel = new ReadViewModel();
        $viewModel->setTemplate($config->getReadViewModelTemplate());
        $viewModel->setVariable('title', $config->getReadViewModelTitle());

        /** @var FormViewModel $formViewModel */
        $formViewModel = $serviceLocator->get('T4webAdmin\View\Model\FormViewModel');
        $formViewModel->setVariable('controller', $config->getReadViewController());
        $formViewModel->setVariable('submitText', $config->getReadViewSubmitText());
        $viewModel->setFormViewModel($formViewModel);

        return $viewModel;
    }
}