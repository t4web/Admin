<?php

namespace T4webAdmin\View\Model;

trait FormViewModelProvider
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

    public function prepare() {}
}
