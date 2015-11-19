<?php

namespace T4webAdmin\View\Model;

use T4webDomainInterface\EntityInterface;
use Sebaks\Crud\View\Model\ReadViewModelInterface;

class ReadViewModel extends BaseViewModel implements ReadViewModelInterface
{
    /**
     * @return EntityInterface
     */
    public function getEntity()
    {
        return $this->getVariable('entity');
    }

    /**
     * @param EntityInterface $entity
     */
    public function setEntity(EntityInterface $entity)
    {
        $this->setVariable('entity', $entity);
    }
}
