<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;
use T4webBase\Domain\Entity;

class UpdateViewModel extends ViewModel
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
     * @var array
     */
    private $inputData;

    /**
     * @var FormViewModel
     */
    private $formViewModel;

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
    public function setMainEntity(Entity $mainEntity)
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
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getInputData()
    {
        return $this->inputData;
    }

    /**
     * @param array $inputData
     */
    public function setInputData(array $inputData)
    {
        $this->inputData = $inputData;
    }

    /**
     * @return FormViewModel
     */
    public function getFormViewModel()
    {
        return $this->formViewModel;
    }

    /**
     * @param FormViewModel $formViewModel
     */
    public function setFormViewModel($formViewModel)
    {
        $this->formViewModel = $formViewModel;
    }
}
