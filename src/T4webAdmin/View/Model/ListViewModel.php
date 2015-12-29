<?php

namespace T4webAdmin\View\Model;

use ArrayObject;
use Sebaks\Crud\View\Model\ListViewModelInterface;

class ListViewModel extends BaseViewModel implements ListViewModelInterface
{
    /**
     * @return ArrayObject
     */
    public function getCollection()
    {
        return $this->getVariable('collection');
    }

    /**
     * @param ArrayObject $collection
     */
    public function setCollection(ArrayObject $collection)
    {
        $this->setVariable('collection', $collection);
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

    /**
     * @return array
     */
    public function getInputData()
    {
        return $this->getVariable('filter');
    }

    /**
     * @param array $filter
     */
    public function setInputData(array $filter)
    {
        $this->setVariable('filter', $filter);
    }
}
