<?php

namespace T4webAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use T4webBase\Domain\Service\BaseFinder as Finder;
use T4webAdmin\View\Model\ReadViewModel;

class ReadController extends AbstractActionController
{
    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var ReadViewModel
     */
    private $viewModel;

    /**
     * @param int $id
     * @param Finder $finder
     * @param ReadViewModel $viewModel
     */
    public function __construct(
        Finder $finder,
        ReadViewModel $viewModel)
    {
        $this->finder = $finder;
        $this->viewModel = $viewModel;
    }

    /**
     * @return ReadViewModel
     */
    public function indexAction()
    {
        $entity = $this->finder->getById($this->params('id'));
        if (!$entity) {
            return $this->notFoundAction();
        }

        $this->viewModel->setMainEntity($entity);

        return $this->viewModel;
    }
}
