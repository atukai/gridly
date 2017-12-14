<?php

namespace Dashboard;

use Dashboard\Paginator\Paginator;
use Dashboard\Source\AbstractSource;

class Grid
{
    /** @var AbstractSource */
    private $source;

    /** @var Paginator */
    private $paginator;

    /**
     * @param AbstractSource $source
     * @param Paginator $paginator
     */
    public function __construct(AbstractSource $source, Paginator $paginator)
    {
        $this->source = $source;
        $this->paginator = $paginator;
    }

    /**
     * @param int|null $page
     * @param array|null $hiddenColumns
     * @return ResultSet
     */
    public function getPageItems(?int $page = 1, ?array $hiddenColumns = []): ResultSet
    {
        return new ResultSet(
            $this->paginator->getPageItems($page),
            $hiddenColumns
        );
    }

    /**
     * @return int
     */
    public function getTotalItems(): int
    {
        return $this->source->count();
    }
}
