<?php

namespace Dashboard\Paginator;

use Pagerfanta\Pagerfanta;

class PagerfantaPaginatorWrapper implements Paginator
{
    /** @var Pagerfanta  */
    private $pagerfantaPaginator;

    /**
     * @param Pagerfanta $paginator
     */
    public function __construct(Pagerfanta $paginator)
    {
        $this->pagerfantaPaginator = $paginator;
    }

    /**
     * @param int $count
     * @return Paginator
     */
    public function setItemsPerPage(int $count = 10): Paginator
    {
        $this->pagerfantaPaginator->setMaxPerPage($count);
        return $this;
    }

    /**
     * @param int $page
     * @return iterable
     */
    public function getPageItems(int $page = 1): iterable
    {
        $this->pagerfantaPaginator->setCurrentPage($page);
        return $this->pagerfantaPaginator->getCurrentPageResults();
    }
}