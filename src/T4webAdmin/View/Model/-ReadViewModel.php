<?php

namespace T4webAdmin\View\Model;

use Sebaks\Crud\View\Model\ReadViewModel as CrudReadViewModel;

class ReadViewModel extends CrudReadViewModel implements EntityManageViewModelInterface
{
    use FormViewModelProvider;

    public function prepare()
    {
        $entity = $this->getEntity();

        $formViewModel = $this->getFormViewModel();
        $formViewModel->setValues($entity->extract());
        $formViewModel->setVariable('entityId', $entity->getId());
    }
}
