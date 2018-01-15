<?php

namespace Gridly\Row;

use ArrayIterator;
use Gridly\Column\Column;
use IteratorAggregate;

class Row implements IteratorAggregate
{
    /** @var Column[] */
    private iterable $columns = [];
    
    public function addColumn(Column $column): void
    {
        $this->columns[] = $column;
    }
    
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->columns);
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
}
