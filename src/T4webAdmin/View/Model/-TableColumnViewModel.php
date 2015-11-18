<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;
use T4webBase\Domain\Entity;

class TableColumnViewModel extends ViewModel
{
    /**
     * @var Entity
     */
    private $entity;

    /**
     * @var mixed
     */
    private $entityAttribute;

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
     * @return mixed
     */
    public function getEntityAttribute()
    {
        return $this->entityAttribute;
    }

    /**
     * @param mixed $entityAttribute
     */
    public function setEntityAttribute($entityAttribute)
    {
        $this->entityAttribute = $entityAttribute;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        $values = $this->entity->extract();
        if (isset($values[$this->entityAttribute])) {
            return $values[$this->entityAttribute];
        }
    }
}
