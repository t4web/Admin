<?php

namespace T4webAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Sebaks\Crud\View\Model\CreateViewModelInterface;

class NewController extends AbstractActionController
{
    /**
     * @var ViewModel
     */
    private $viewModel;

    /**
     * NewController constructor.
     * @param CreateViewModelInterface $viewModel
     */
    public function __construct(CreateViewModelInterface $viewModel)
    {
        $this->viewModel = $viewModel;
    }

    /**
     * Execute the request
     *
     * @param  MvcEvent $e
     * @return CreateViewModelInterface
     */
    public function onDispatch(MvcEvent $e)
    {
        $e->setResult($this->viewModel);
        return $this->viewModel;
    }
}
