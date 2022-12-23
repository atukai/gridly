<?php

namespace Gridly\Paginator\Laminas;

use Gridly\Paginator\Paginator;

class LaminasPaginator implements Paginator
{
    private \Laminas\Paginator\Paginator $laminasPaginator;

    public function __construct(\Laminas\Paginator\Paginator $paginator)
    {
        $this->laminasPaginator = $paginator;
    }

    public function setItemsPerPage(int $count = 10): Paginator
    {
        $this->laminasPaginator->setItemCountPerPage($count);
        return $this;
    }

    public function getPageItems(int $page = 1): iterable
    {
        $this->laminasPaginator->setCurrentPageNumber($page);
        return $this->laminasPaginator->getCurrentItems();
    }

    public function getCurrentPage(): int
    {
        return $this->laminasPaginator->getCurrentPageNumber();
    }

    public function getTotalPages(): int
    {
        return $this->laminasPaginator->count();
    }
}
