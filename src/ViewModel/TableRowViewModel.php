<?php


namespace T4web\Admin\ViewModel;

use Zend\View\Model\ViewModel;

class TableRowViewModel extends ViewModel
{
    public function getVariable($name, $default = null)
    {
        $row = parent::getVariable('row', []);

        if ($name == 'createdDt' || $name == 'updatedDt') {
            return date("Y-m-d H:i:s", strtotime($row[$name]));
        }

        if (isset($row[$name])) {
            return $row[$name];
        }

        return parent::getVariable($name, $default);
    }
}