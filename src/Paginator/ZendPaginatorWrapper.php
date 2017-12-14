<?php

namespace Dashboard\Paginator;

class ZendPaginatorWrapper implements Paginator
{
    /** @var \Zend\Paginator\Paginator  */
    private $zendPaginator;

    /**
     * @param \Zend\Paginator\Paginator $paginator
     */
    public function __construct(\Zend\Paginator\Paginator $paginator)
    {
        $this->zendPaginator = $paginator;
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setItemsPerPage(int $count = 10): Paginator
    {
        $this->zendPaginator->setItemCountPerPage($count);
        return $this;
    }

    /**
     * @param int $page
     * @return iterable
     */
    public function getPageItems(int $page = 1): iterable
    {
        $this->zendPaginator->setCurrentPageNumber($page);
        return $this->zendPaginator->getCurrentItems();
    }
}