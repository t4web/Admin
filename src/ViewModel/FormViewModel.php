<?php

namespace T4web\Admin\ViewModel;

use Zend\View\Model\ViewModel;

class FormViewModel extends ViewModel
{
    public function getVariable($name, $default = null)
    {
        $entity = parent::getVariable('result');

        if ($entity) {
            $data = $entity->extract();

            if (isset($data[$name])) {
                return $data[$name];
            }
        }

        return parent::getVariable($name, $default);
    }
}