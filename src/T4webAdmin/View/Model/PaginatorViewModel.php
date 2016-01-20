<?php

namespace T4webAdmin\View\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\NullFill;
use T4webDomainInterface\Infrastructure\RepositoryInterface;
use Zend\InputFilter\InputFilterInterface;

class PaginatorViewModel extends BaseViewModel
{
    /**
     * @var array
     */
    private $query;

    /**
     * @var RepositoryInterface
     */
    private $finder;

    /**
     * @var InputFilterInterface
     */
    private $inputFilter;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $itemsCountPerPage;

    /**
     * @param RepositoryInterface  $finder
     * @param array                $query
     * @param InputFilterInterface $inputFilter
     */
    public function __construct(RepositoryInterface $finder, array $query = [], InputFilterInterface $inputFilter = null)
    {
        $this->finder = $finder;
        $this->query = $query;
        $this->inputFilter = $inputFilter;
        $this->currentPage = isset($query['page']) ? $query['page'] : 1;
        $this->itemsCountPerPage = isset($query['limit']) ? $query['limit'] : 20;
    }

    /**
     * @return void
     */
    public function initialize()
    {
        if ($this->inputFilter) {
            $this->inputFilter->setData($this->query);
            $this->inputFilter->isValid();
            $this->query = $this->inputFilter->getValues();
        }

        $criteria = $this->finder->createCriteria($this->query);
        $this->count = $this->finder->count($criteria);

        $this->paginator = new Paginator(new NullFill($this->count));
        $this->paginator->setCurrentPageNumber($this->currentPage);
        $this->paginator->setDefaultItemCountPerPage($this->itemsCountPerPage);
        $this->paginator->setPageRange(5);
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    public function getItemsCountPerPage()
    {
        return $this->itemsCountPerPage;
    }

    /**
     * @return bool
     */
    public function isPrevBtnActive()
    {
        return $this->paginator->getPages()->first != $this->paginator->getPages()->current;
    }

    /**
     * @return bool
     */
    public function isNextBtnActive()
    {
        return $this->paginator->getPages()->last != $this->paginator->getPages()->current;
    }

    /**
     * @return array
     */
    public function getPagesInRange()
    {
        return $this->paginator->getPages()->pagesInRange;
    }

    /**
     * @param $page int
     * @return bool
     */
    public function isCurrentPage($page)
    {
        return $this->paginator->getPages()->current == $page;
    }

    /**
     * @param $page int
     * @return string
     */
    public function getUrlForPage($page)
    {
        if ($this->isCurrentPage($page)) {
            return '#';
        }

        $queryParams = $this->query;
        $queryParams['page'] = $page;

        $queryString = http_build_query($queryParams);

        return '?' . $queryString;
    }

    /**
     * @param int $limit
     *
     * @return string
     */
    public function getUrlForLimit($limit)
    {
        $queryParams = $this->query;
        $queryParams['limit'] = $limit;
        $queryParams['page'] = 1;

        $queryString = http_build_query($queryParams);

        return '?' . $queryString;
    }

    /**
     * @return bool
     */
    public function canRenderLastPageBtn()
    {
        return $this->paginator->getPages()->last > $this->paginator->getPages()->lastPageInRange;
    }

    /**
     * @return int
     */
    public function getLastPage()
    {
        return $this->paginator->getPages()->last;
    }

    /**
     * @return int
     */
    public function getNextPage()
    {
        return $this->paginator->getPages()->current + 1;
    }

    /**
     * @return int
     */
    public function getPrevPage()
    {
        return $this->paginator->getPages()->current - 1;
    }
}
