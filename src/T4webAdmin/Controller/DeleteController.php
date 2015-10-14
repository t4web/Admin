<?php

namespace T4webAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use T4webBase\Domain\Service\Delete as Deleter;
use T4webAdmin\View\Model\DeleteViewModel;

class DeleteController extends AbstractActionController
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Deleter
     */
    private $deleter;

    /**
     * @var DeleteViewModel
     */
    private $viewModel;

    /**
     * @var string
     */
    private $redirectTo;

    /**
     * @param $id
     * @param Deleter $deleter
     * @param DeleteViewModel $viewModel
     * @param null $redirectTo
     */
    public function __construct($id, Deleter $deleter, DeleteViewModel $viewModel, $redirectTo = null)
    {
        $this->id = $id;
        $this->deleter = $deleter;
        $this->viewModel = $viewModel;
        $this->redirectTo = $redirectTo;
    }

    /**
     * @return DeleteViewModel|\Zend\Http\Response
     */
    public function indexAction()
    {
        $isSuccess = $this->deleter->delete($this->id);
        $this->viewModel->setResult($isSuccess);
        $entity = $this->deleter->getEntity();

        if ($isSuccess) {
            if ($this->redirectTo) {
                return $this->redirect()->toRoute($this->redirectTo);
            }

            $this->viewModel->setMainEntity($entity);
        } else {
            if (!$entity) {
                return $this->notFoundAction();
            }

            $this->viewModel->setErrors($this->deleter->getErrors()->toArray());
            $this->viewModel->setMainEntity($entity);
        }

        return $this->viewModel;
    }
}
