<?php

namespace Gridly;

use Gridly\Paginator\Paginator;
use Gridly\Paginator\PaginatorFactory;
use Gridly\Source\Source;

class Storage
{
    private Source $source;
    private Paginator $paginator;

    public function __construct(Source $source, PaginatorFactory $paginatorFactory, array $paginatorOptions)
    {
        $this->source = $source;
        $this->paginator = $paginatorFactory->create($source, $paginatorOptions);
    }

    public function getPageItems(int $page): iterable
    {
        return $this->paginator->getPageItems($page);
    }

    public function count(): int
    {
        return $this->source->count();
    }

    public function countAll(): int
    {
        return $this->source->countAll();
    }

    public function getTotalPages(): int
    {
        return $this->paginator->getTotalPages();
    }

    public function getCurrentPage(): int
    {
        return $this->paginator->getCurrentPage();
    }

    public function getSchemaParams(): array
    {
        return $this->source->getSchemaParams();
    }
}
