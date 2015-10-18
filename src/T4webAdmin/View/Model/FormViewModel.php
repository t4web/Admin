<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;

class FormViewModel extends ViewModel
{
    /**
     * @var array
     */
    private $values = [];

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues($values)
    {
        $this->values = $values;
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
}
