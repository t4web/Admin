<?php

namespace T4webAdmin\InputFilter;

use T4webBase\InputFilter\Filter;
use T4webBase\InputFilter\Element\Int;

class CreateInputFilter extends Filter
{
    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $entity;

    /**
     * @param string $entity
     * @param string $module
     */
    public function __construct($module, $entity)
    {
        $this->module = $module;
        $this->entity = $entity;
    }

    /**
     * @return array
     */
    public function getValuesByModules()
    {
        return [
            $this->module => [
                $this->entity => $this->getValues()
            ],
        ];
    }
}