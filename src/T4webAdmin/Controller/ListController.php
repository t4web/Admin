<?php

namespace T4webAdmin\Controller;

use T4webActionInjections\Mvc\Controller\AbstractActionController;
use T4webBase\InputFilter\Filter;
use T4webBase\Domain\Service\BaseFinder as Finder;
use T4webAdmin\View\Model\ListViewModel;

class ListController extends AbstractActionController
{
    /**
     * @var array
     */
    private $query;

    /**
     * @var Filter
     */
    private $inputFilter;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var ListViewModel
     */
    private $viewModel;

    /**
     * ListController constructor.
     * @param array $query
     * @param Filter $inputFilter
     * @param Finder $finder
     * @param ListViewModel $viewModel
     */
    public function __construct(
        array $query,
        Filter $inputFilter,
        Finder $finder,
        ListViewModel $viewModel
    )
    {
        $this->query = $query;
        $this->inputFilter = $inputFilter;
        $this->finder = $finder;
        $this->viewModel = $viewModel;
    }

    /**
     * @return ListViewModel
     */
    public function listAction()
    {
        $query = $this->inputFilter->filter($this->query);

        $collection = $this->finder->findMany($query);

        $this->viewModel->setMainCollection($collection);

        return $this->viewModel;
    }
}
