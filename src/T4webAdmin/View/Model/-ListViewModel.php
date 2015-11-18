<?php

namespace T4webAdmin\View\Model;

use Sebaks\Crud\View\Model\ListViewModel as CrudListViewModel;

class ListViewModel extends CrudListViewModel
{
    /**
     * @var string
     */
    private $routeName;

    /**
     * @var TableViewModel
     */
    private $tableViewModel;

    /**
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * @param string $routeName
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;
    }

    /**
     * @return TableViewModel
     */
    public function getTableViewModel()
    {
        return $this->tableViewModel;
    }

    /**
     * @param TableViewModel $tableViewModel
     */
    public function setTableViewModel($tableViewModel)
    {
        $this->tableViewModel = $tableViewModel;
    }
}
