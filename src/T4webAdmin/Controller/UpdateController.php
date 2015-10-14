<?php

namespace T4webAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use T4webBase\Domain\Service\Update as Updater;
use T4webAdmin\View\Model\UpdateViewModel;

class UpdateController extends AbstractActionController
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $data;

    /**
     * @var Updater
     */
    private $updater;

    /**
     * @var UpdateViewModel
     */
    private $viewModel;

    /**
     * @var string
     */
    private $redirectTo;


    /**
     * @param $id
     * @param array $data
     * @param Updater $updater
     * @param UpdateViewModel $viewModel
     * @param null $redirectTo
     */
    public function __construct($id, array $data, Updater $updater, UpdateViewModel $viewModel, $redirectTo = null)
    {
        $this->id = $id;
        $this->data = $data;
        $this->updater = $updater;
        $this->viewModel = $viewModel;
        $this->redirectTo = $redirectTo;
    }

    /**
     * @return array|UpdateViewModel|\Zend\Http\Response
     */
    public function indexAction()
    {
        $isSuccess = $this->updater->update($this->id, $this->data);
        $entity = $this->updater->getEntity();

        if ($isSuccess) {
            if ($this->redirectTo) {
                return $this->redirect()->toRoute($this->redirectTo);
            }

            $this->viewModel->setInputData($this->updater->getValues());
            $this->viewModel->setMainEntity($entity);
        } else {
            if (!$entity) {
                return $this->notFoundAction();
            }

            $this->viewModel->setErrors($this->updater->getErrors()->toArray());
            $this->viewModel->setInputData($this->updater->getValues());
            $this->viewModel->setMainEntity($entity);
        }

        return $this->viewModel;
    }
}
