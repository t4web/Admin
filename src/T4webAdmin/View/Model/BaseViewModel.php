<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;
use Zend\View\Model\ModelInterface;

class BaseViewModel extends ViewModel
{
    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function pushChild(ModelInterface $child, $name)
    {
        $this->children[$name] = $child;
        return $this;
    }

    /**
     * @param $name
     * @return ModelInterface
     */
    public function getChild($name)
    {
        return $this->children[$name];
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }
}
