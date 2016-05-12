<?php

namespace T4web\Admin\ViewModel;

use Zend\View\Model\ViewModel;

class EditButtonViewModel extends ViewModel
{
    public function getVariable($name, $default = null)
    {
        if ($name == 'routeParams') {
            $id = parent::getVariable('id');
            return ['id' => $id];
        }

        return parent::getVariable($name, $default);
    }
}