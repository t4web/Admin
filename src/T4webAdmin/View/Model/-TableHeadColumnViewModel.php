<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;

class TableHeadColumnViewModel extends ViewModel
{
    /**
     * @var string
     */
    private $value;

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
