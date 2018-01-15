<?php

namespace Gridly\Paginator\Laminas;

use Gridly\Source\Source;
use Laminas\Paginator\Adapter\AdapterInterface as LaminasPaginatorAdapterInterface;

class LaminasPaginatorAdapter implements LaminasPaginatorAdapterInterface
{
    private Source $source;
    
    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    public function getItems($offset, $itemCountPerPage): iterable
    {
        return $this->source->getItems($offset, $itemCountPerPage);
    }

    public function count(): int
    {
        return $this->source->count();
    }
}
