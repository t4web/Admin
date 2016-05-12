<?php


namespace T4web\Admin\ViewModel;

use Zend\View\Model\ViewModel;
use T4webDomainInterface\EntityInterface;

class TableViewModel extends ViewModel
{
    public function getVariable($name, $default = null)
    {
        if ($name == 'rowsData') {
            $bodyRowsData = parent::getVariable('rowsData');

            if (! $bodyRowsData instanceof \ArrayObject) {
                throw new \RuntimeException('Variable result must be instance of ' . \ArrayObject::class . '. '
                    . gettype($bodyRowsData) . ' given');
            }

            $result = [];
            foreach ($bodyRowsData as $rowData) {
                if (! $rowData instanceof EntityInterface) {
                    throw new \RuntimeException('Variable result must be instance of ' . EntityInterface::class . '. '
                        . gettype($rowData) . ' given');
                }

                $row = $rowData->extract();
                $result[] = $row;
            }

            return $result;
        }

        if ($name == 'headRows') {

            $columnsConf = parent::getVariable('columns');

            $result = [];
            $row = [];
            foreach ($columnsConf as $columnConf) {
                $row[] = $columnConf['head'];
            }
            $result[] = $row;

            return $result;
        }

        return parent::getVariable($name, $default);
    }
}