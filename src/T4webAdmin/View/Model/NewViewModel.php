<?php

namespace T4webAdmin\View\Model;

use Sebaks\Crud\View\Model\CreateViewModel as CrudCreateViewModel;

class NewViewModel extends CrudCreateViewModel implements EntityManageViewModelInterface
{
    use FormViewModelProvider;

    public function prepare() {}
}
