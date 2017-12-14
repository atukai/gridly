<?php

namespace Dashboard\Paginator;

interface Paginator
{
    /**
     * @param int $page
     * @return Paginator
     */
    public function setItemsPerPage(int $page = 10): Paginator;

    /**
     * @param int $page
     * @return iterable
     */
    public function getPageItems(int $page = 1): iterable;
}