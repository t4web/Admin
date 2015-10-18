<?php

namespace T4webAdmin\View\Model;

use Sebaks\Crud\View\Model\CreateViewModel as CrudCreateViewModel;

class CreateViewModel extends CrudCreateViewModel implements EntityManageViewModelInterface
{
    use FormViewModelProvider;

    public function prepare()
    {
        $formViewModel = $this->getFormViewModel();
        $formViewModel->setValues($this->getInputData());
        $formViewModel->setErrors($this->getErrors());
    }
}
