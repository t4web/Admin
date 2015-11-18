<?php

namespace T4webAdmin\View\Model;

use Sebaks\Crud\View\Model\UpdateViewModel as CrudUpdateViewModel;

class UpdateViewModel extends CrudUpdateViewModel implements EntityManageViewModelInterface
{
    use FormViewModelProvider;

    public function prepare()
    {
        $entity = $this->getEntity();

        $formViewModel = $this->getFormViewModel();
        $formViewModel->setValues($this->getInputData());
        $formViewModel->setErrors($this->getErrors());
        $formViewModel->setVariable('entityId', $entity->getId());
    }
}
