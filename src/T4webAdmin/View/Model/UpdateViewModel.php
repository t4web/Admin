<?php

namespace T4webAdmin\View\Model;

use Sebaks\Crud\View\Model\UpdateViewModel as CrudUpdateViewModel;

class UpdateViewModel extends CrudUpdateViewModel
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
