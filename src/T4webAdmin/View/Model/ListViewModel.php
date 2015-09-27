<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;
use T4webBase\Domain\Collection;

class ListViewModel extends ViewModel
{
    /**
     * @var string
     */
    private $routeName;

    /**
     * @var Collection
     */
    private $mainCollection;

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
