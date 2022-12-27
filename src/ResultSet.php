<?php

namespace Gridly;

use ArrayIterator;
use Countable;
use Gridly\Column\Column;
use Gridly\Column\Definitions;
use Gridly\Row\Row;
use IteratorAggregate;
use JsonSerializable;

class ResultSet implements Countable, IteratorAggregate, JsonSerializable
{
    private Row $headersRow;

    /** @var Row[] */
    private array $rows;

    public function __construct(iterable $data, Definitions $columnDefinitions)
    {
        $this->rows = [];
        $this->createRows($data, $columnDefinitions);
    }

    public function getHeadersRow(): Row
    {
        return $this->headersRow;
    }

    public function count(): int
    {
        return count($this->rows);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->rows);
    }

    public function toArray(): array
    {
        return $this->rows;
    }

    public function jsonSerialize(): array
    {
        return $this->rows;
    }

    private function createRows(iterable $entries, Definitions $columnDefinitions): void
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

                /**
                 * Check if decorators are added for column.
                 * Run decorators pipeline for column
                 */
                if (!$columnDefinition->getDecorators()->isEmpty()) {
                    $column = $columnDefinition->getDecorators()($column, $entry);
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
