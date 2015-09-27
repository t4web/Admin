<?php

namespace T4webAdmin\InputFilter;

use T4webBase\InputFilter\Filter;
use T4webBase\InputFilter\Element\Int;

class ListInputFilter extends Filter
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

        $page = new Int('page');
        $page->setDefaultValue(1);

        $limit = new Int('limit');
        $limit->setDefaultValue(20);

        $this->add($page);
        $this->add($limit);
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