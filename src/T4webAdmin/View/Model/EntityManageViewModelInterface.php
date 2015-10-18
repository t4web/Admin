<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ModelInterface;

interface EntityManageViewModelInterface extends ModelInterface
{
    public function getFormViewModel();

    public function prepare();
}
