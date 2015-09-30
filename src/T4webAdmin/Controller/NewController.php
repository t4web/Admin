<?php

namespace T4webAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class NewController extends AbstractActionController
{
    /**
     * @var ViewModel
     */
    private $viewModel;

    /**
     * NewController constructor.
     * @param ViewModel $viewModel
     */
    public function __construct(ViewModel $viewModel)
    {
        $this->viewModel = $viewModel;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return $this->viewModel;
    }
}
