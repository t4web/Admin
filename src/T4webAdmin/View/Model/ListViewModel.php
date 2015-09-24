<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;
use T4webBase\Domain\Collection;

class ListViewModel extends ViewModel
{
    /**
     * @var Collection
     */
    private $mainCollection;

    /**
     * @param Collection $collection
     * @return void
     */
    public function setMainCollection(Collection $collection)
    {
        $this->mainCollection = $collection;
    }

    /**
     * @return Collection|null
     */
    public function getMainCollection()
    {
        return $this->mainCollection;
    }
}
