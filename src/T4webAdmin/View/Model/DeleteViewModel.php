<?php

namespace T4webAdmin\View\Model;

use T4webDomainInterface\EntityInterface;
use Sebaks\Crud\View\Model\DeleteViewModelInterface;

class DeleteViewModel extends BaseViewModel implements DeleteViewModelInterface
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

    /**
     * @param string $name
     * @return array
     */
    public function getErrors($name = null)
    {
        $errors = $this->getVariable('errors');

        if (!empty($name)) {
            if (array_key_exists($name, $errors)) {
                return $errors[$name];
            } else {
                return [];
            }
        }

        return $this->getVariable('errors');
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors)
    {
        $this->setVariable('errors', $errors);
    }
}
