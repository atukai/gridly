<?php

namespace Gridly\Row;

use ArrayIterator;
use Gridly\Column\Column;
use IteratorAggregate;
use JsonSerializable;

class Row implements IteratorAggregate, JsonSerializable
{
    /** @var Column[] */
    private iterable $columns = [];

    public function addColumn(Column $column): void
    {
        $this->columns[] = $column;
    }

    /**
     * @return string[]
     */
    public function getNames(): array
    {
        $names = [];
        foreach ($this->columns as $column) {
            $names[] = $column->label();
        }

        return $names;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->columns);
    }

    public function jsonSerialize(): iterable
    {
        return $this->columns;
    }
}
