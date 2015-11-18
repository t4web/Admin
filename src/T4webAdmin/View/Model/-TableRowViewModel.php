<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;
use T4webBase\Domain\Entity;

class TableRowViewModel extends ViewModel
{
    /**
     * @var Entity
     */
    private $entity;

    /**
     * @var array
     */
    private $columnsViewModels = [];

    /**
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param Entity $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return array
     */
    public function getColumnsViewModels()
    {
        return $this->columnsViewModels;
    }

    /**
     * @param TableColumnViewModel $columnViewModel
     */
    public function addColumnView(TableColumnViewModel $columnViewModel)
    {
        $this->columnsViewModels[] = $columnViewModel;
    }
}
