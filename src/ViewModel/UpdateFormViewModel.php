<?php

namespace T4web\Admin\ViewModel;

use Zend\View\Model\ViewModel;

class UpdateFormViewModel extends ViewModel
{
    public function getVariable($name, $default = null)
    {
        $changes = parent::getVariable('changes');

        if (isset($changes[$name])) {
            return $changes[$name];
        }
        if (strpos($name, 'changesErrors:') === 0) {
            $changesErrors = parent::getVariable('changesErrors', []);

            if (!empty($changesErrors)) {
                $explodedName = explode(':', $name);
                if (isset($explodedName[1])) {
                    $elementName = $explodedName[1];

                    if (isset($changesErrors[$elementName])) {
                        return $changesErrors[$elementName];
                    }
                }
            }
        }

        return parent::getVariable($name, $default);
    }
}