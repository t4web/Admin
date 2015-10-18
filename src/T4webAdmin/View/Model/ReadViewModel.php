<?php

namespace T4webAdmin\View\Model;

use Sebaks\Crud\View\Model\ReadViewModel as CrudReadViewModel;

class ReadViewModel extends CrudReadViewModel
{
    /**
     * @var FormViewModel
     */
    private $formViewModel;

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
