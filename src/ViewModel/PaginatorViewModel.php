<?php

namespace T4web\Admin\ViewModel;

use Zend\Paginator\Paginator as ZendPaginator;
use Zend\Paginator\Adapter\NullFill;
use T4webDomainInterface\Infrastructure\RepositoryInterface;
use Zend\View\Model\ViewModel as ZendViewModel;

class PaginatorViewModel extends ZendViewModel
{
    /**
     * @var string
     */
    protected $template = 't4web-paginator/paginator.phtml';
    /**
     * @var array
     */
    protected $criteria;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var ZendPaginator
     */
    protected $zendPaginator;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var int
     */
    protected $itemsCountPerPage;

    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return void
     */
    public function initialize()
    {
        $this->criteria = $this->getVariable('validCriteria', []);
        $this->currentPage = isset($this->criteria['page']) ? $this->criteria['page'] : 1;
        $this->itemsCountPerPage = isset($this->criteria['limit']) ? $this->criteria['limit'] : 20;

        $criteria = $this->repository->createCriteria($this->criteria);
        $this->count = $this->repository->count($criteria);

        $this->zendPaginator = new ZendPaginator(new NullFill($this->count));
        $this->zendPaginator->setCurrentPageNumber($this->currentPage);
        $this->zendPaginator->setDefaultItemCountPerPage($this->itemsCountPerPage);
        $this->zendPaginator->setPageRange(5);
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return int
     */
    public function getItemsCountPerPage()
    {
        return $this->itemsCountPerPage;
    }

    /**
     * @return bool
     */
    public function isPrevBtnActive()
    {
        return $this->zendPaginator->getPages()->first != $this->zendPaginator->getPages()->current;
    }

    /**
     * @return bool
     */
    public function isNextBtnActive()
    {
        return $this->zendPaginator->getPages()->last != $this->zendPaginator->getPages()->current;
    }

    /**
     * @return array
     */
    public function getPagesInRange()
    {
        return $this->zendPaginator->getPages()->pagesInRange;
    }

    /**
     * @param $page int
     * @return bool
     */
    public function isCurrentPage($page)
    {
        return $this->zendPaginator->getPages()->current == $page;
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

        $queryParams = $this->criteria;
        $queryParams['page'] = $page;
        $queryParams['limit'] = $this->itemsCountPerPage;

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
        $queryParams = $this->criteria;
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
        return $this->zendPaginator->getPages()->last > $this->zendPaginator->getPages()->lastPageInRange;
    }

    /**
     * @return int
     */
    public function getLastPage()
    {
        return $this->zendPaginator->getPages()->last;
    }

    /**
     * @return int
     */
    public function getNextPage()
    {
        return $this->zendPaginator->getPages()->current + 1;
    }

    /**
     * @return int
     */
    public function getPrevPage()
    {
        return $this->zendPaginator->getPages()->current - 1;
    }
}
