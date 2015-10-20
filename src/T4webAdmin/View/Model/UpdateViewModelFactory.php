<?php

namespace T4webAdmin\View\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4webAdmin\Config;

class UpdateViewModelFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');

        $viewModel = new UpdateViewModel();
        $viewModel->setTemplate($config->getUpdateViewModelTemplate());
        $viewModel->setVariable('title', $config->getUpdateViewModelTitle());

        $formViewModel = $serviceLocator->get('T4webAdmin\View\Model\FormViewModel');
        $formViewModel->setVariable('controller', $config->getUpdateViewController());
        $formViewModel->setVariable('submitText', $config->getUpdateViewSubmitText());
        $viewModel->setFormViewModel($formViewModel);

        return $viewModel;
    }
}