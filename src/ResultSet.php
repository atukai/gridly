<?php

namespace Gridly;

use ArrayIterator;
use Countable;
use Gridly\Column\Column;
use Gridly\Column\Definitions;
use Gridly\Column\Exception;
use Gridly\Row\Row;
use IteratorAggregate;

class ResultSet implements Countable, IteratorAggregate
{
    private Row $headersRow;
    
    /** @var Row[] */
    private array $rows;
    
    /**
     * @throws Exception
     */
    public function __construct(iterable $data, Definitions $columnDefinitions, array $columnDecorators = [])
    {
        $this->rows = [];
        $this->prepareRows($data, $columnDefinitions, $columnDecorators);
    }
    
    public function getHeadersRow(): Row
    {
        return $this->headersRow;
    }
    
    public function getRows(): array
    {
        return $this->rows;
    }
    
    public function count(): int
    {
        return count($this->rows);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->rows);
    }
    
    /**
     * @throws Exception
     */
    private function prepareRows(iterable $entries, Definitions $columnDefinitions, array $columnDecorators = []): void
    {
        foreach ($entries as $i => $entry) {
            $row = new Row();
            
            foreach ($entry as $name => $value) {
                $columnDefinition = $columnDefinitions->get($name);
                
                if (!$columnDefinition->isVisible()) {
                    continue;
                }
                
                $column = new Column(
                    $name,
                    $value,
                    $columnDefinition->getType(),
                    $columnDefinition->getLabel(),
                    $columnDefinition->isSortable(),
                    $columnDefinition->isFilterable()
                );
                
                if (isset($columnDecorators[$column->name()])) {
                    $decorator = $columnDecorators[$column->name()];
                    $column = $decorator($column, $entry);
                }

                $row->addColumn($column);
            }
            
            // First row for headers
            if ($i === 0) {
                $this->headersRow = $row;
            }
            
            $this->rows[] = $row;
        }
    }
}
