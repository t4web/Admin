<?php

namespace T4webAdmin\View\Model;

use ArrayObject;
use Sebaks\Crud\View\Model\ListViewModelInterface;

class ListViewModel extends BaseViewModel implements ListViewModelInterface
{
    /**
     * @return ArrayObject
     */
    public function getCollection()
    {
        return $this->getVariable('collection');
    }

    /**
     * @param ArrayObject $collection
     */
    public function setCollection(ArrayObject $collection)
    {
        $this->setVariable('collection', $collection);
    }

    /**
     * @return array
     */
    public function getFilter()
    {
        return $this->getVariable('filter');
    }

    /**
     * @param array $filter
     */
    public function setFilter(array $filter)
    {
        $this->setVariable('filter', $filter);
    }
}
