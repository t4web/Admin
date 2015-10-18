<?php

namespace T4webAdmin\View\Model;

use Sebaks\Crud\View\Model\CreateViewModel as CrudCreateViewModel;

class CreateViewModel extends CrudCreateViewModel
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
