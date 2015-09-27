<?php

namespace T4webAdmin\Controller;

use T4webActionInjections\Mvc\Controller\AbstractActionController;
use T4webBase\InputFilter\Filter;
use T4webBase\Domain\Service\BaseFinder as Finder;
use T4webAdmin\View\Model\ListViewModel;

class CrudController extends AbstractActionController
{
    /**
     * List action
     *
     * @param array $query
     * @param Filter $inputFilter
     * @param Finder $finder
     * @param ListViewModel $listViewModel
     * @return ListViewModel
     */
    public function listAction(
        array $query,
         $inputFilter,
        Finder $finder,
        ListViewModel $listViewModel
    ) {
        $query = $inputFilter->filter($query);

        $collection = $finder->findMany($query);

        $listViewModel->setMainCollection($collection);

        return $listViewModel;
    }
}
