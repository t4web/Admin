<?php

namespace T4webAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use T4webBase\Domain\Service\NewCreate as Creator;
use T4webAdmin\View\Model\CreateViewModel;

class CreateController extends AbstractActionController
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var Creator
     */
    private $creator;

    /**
     * @var CreateViewModel
     */
    private $viewModel;

    /**
     * @var string
     */
    private $redirectTo;

    /**
     * @param array $data
     * @param Creator $creator
     * @param CreateViewModel $viewModel
     * @param null $redirectTo
     */
    public function __construct(
        array $data,
        Creator $creator,
        CreateViewModel $viewModel,
        $redirectTo = null)
    {
        $this->data = $data;
        $this->creator = $creator;
        $this->viewModel = $viewModel;
        $this->redirectTo = $redirectTo;
    }

    /**
     * @return CreateViewModel
     */
    public function indexAction()
    {
        $entity = $this->creator->create($this->data);

        if ($entity) {
            if ($this->redirectTo) {
                return $this->redirect()->toRoute($this->redirectTo);
            }
            $this->viewModel->setMainEntity($entity);
        } else {
            $this->viewModel->setErrors($this->creator->getMessages());
            $this->viewModel->setInputData($this->creator->getValues());
        }

        return $this->viewModel;
    }
}
