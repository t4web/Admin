<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;

class TableHeadViewModel extends ViewModel
{
    /**
     * @var array
     */
    private $columnsViewModels = [];

    /**
     * @return array
     */
    public function getColumnsViewModels()
    {
        return $this->columnsViewModels;
    }

    /**
     * @param TableHeadColumnViewModel $columnViewModel
     */
    public function addColumnView(TableHeadColumnViewModel $columnViewModel)
    {
        $this->columnsViewModels[] = $columnViewModel;
    }
}
