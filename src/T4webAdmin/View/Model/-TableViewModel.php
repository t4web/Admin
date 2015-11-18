<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;
use T4webBase\Domain\Collection;

class TableViewModel extends ViewModel
{
    /**
     * @var Collection
     */
    private $entities;

    /**
     * @var TableHeadViewModel
     */
    private $headView;

    /**
     * @var TableRowViewModel
     */
    private $rowView;

    /**
     * @return Collection
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @param Collection $entities
     */
    public function setEntities($entities)
    {
        $this->entities = $entities;
    }

    /**
     * @return TableRowViewModel
     */
    public function getRowView()
    {
        return $this->rowView;
    }

    /**
     * @param TableRowViewModel $rowView
     */
    public function setRowView($rowView)
    {
        $this->rowView = $rowView;
    }

    /**
     * @return TableHeadViewModel
     */
    public function getHeadView()
    {
        return $this->headView;
    }

    /**
     * @param TableHeadViewModel $headView
     */
    public function setHeadView($headView)
    {
        $this->headView = $headView;
    }
}
