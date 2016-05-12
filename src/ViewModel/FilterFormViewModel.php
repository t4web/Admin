<?php

namespace T4web\Admin\ViewModel;

use Zend\View\Model\ViewModel;

class FilterFormViewModel extends ViewModel
{
    public function getVariable($name, $default = null)
    {
        $validCriteria = parent::getVariable('validCriteria');

        if (!empty($validCriteria[$name])) {
            return $validCriteria[$name];
        }
        return parent::getVariable($name, $default);
    }
}