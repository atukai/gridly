<?php

namespace Gridly\Paginator\Pagerfanta;

use Gridly\Source\Source;
use Pagerfanta\Adapter\AdapterInterface as PagerfantaPaginatorAdapterInterface;

class PagerfantaPaginatorAdapter implements PagerfantaPaginatorAdapterInterface
{
    private Source $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    public function getNbResults(): int
    {
        return $this->source->count();
    }

    /**
     * @param int $offset
     * @param int $length
     * @return iterable
     */
    public function getSlice(int $offset, int $length): iterable
    {
        return $this->source->getItems($offset, $length);
    }
}
