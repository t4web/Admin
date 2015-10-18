<?php

namespace T4webAdmin\View\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

class FormViewModelFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \T4webAdmin\Config $config */
        $config = $serviceLocator->get('T4webAdmin\Config');

        $formViewModel = new FormViewModel();
        $formViewModel->setTemplate($config->getFormTemplate());
        $formViewModel->setVariable('route', $config->getRoute());

        $elements = $config->getFormElements();

        foreach ($elements as $i => $element) {
            if (empty($element['type'])) {
                throw new \UnexpectedValueException("FormViewModel factory: element $i type is undefined");
            }

            $elementTemplate = $config->getFormElementTemplate($element);

            $elementView = new ViewModel();
            $elementView->setTemplate($elementTemplate);

            if (!empty($element['variables']) && !is_array($element['variables'])) {
                if (!is_array($element['variables'])) {
                    throw new \UnexpectedValueException("FormViewModel factory: element $i variables must be array");
                }

                $elementView->setVariables($element['variables']);
            }

            $formViewModel->addChild($elementView);
        }

        return $formViewModel;
    }
}