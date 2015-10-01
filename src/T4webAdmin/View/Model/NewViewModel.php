<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;
use Zend\Form\Form;

class NewViewModel extends ViewModel
{
    /**
     * @var Form
     */
    private $form;

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param Form $form
     */
    public function setForm($form)
    {
        $this->form = $form;
    }
}
