<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use T4webBase\Domain\Entity;

class ReadViewModel extends ViewModel
{
    /**
     * @var Entity
     */
    private $mainEntity;

    /**
     * @var NewForm
     */
    private $form;

    /**
     * @return Entity
     */
    public function getMainEntity()
    {
        return $this->mainEntity;
    }

    /**
     * @param Entity $mainEntity
     */
    public function setMainEntity(Entity $mainEntity)
    {
        $this->mainEntity = $mainEntity;
    }

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
