<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;
use T4webBase\Domain\Entity;

class DeleteViewModel extends ViewModel
{
    /**
     * @var Entity
     */
    private $mainEntity;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var bool
     */
    private $result;

    /**
     * @return Entity
     */
    public function getMainEntity()
    {
        return $this->mainEntity;
    }

    /**
     * @param Entity $mainEntity
     */
    public function setMainEntity($mainEntity)
    {
        $this->mainEntity = $mainEntity;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return boolean
     */
    public function isResult()
    {
        return $this->result;
    }

    /**
     * @param boolean $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }
}
