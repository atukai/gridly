<?php

namespace Gridly\Schema\Filter;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class FilterSet implements Countable, IteratorAggregate
{
    /**
     * @var Filter[]
     */
    private array $filters = [];
    
    public function __construct(iterable $filters = [])
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }
    
    public function addFilter(Filter $filter): void
    {
        $this->filters[] = $filter;
    }
    
    public function merge(FilterSet|iterable $filters): void
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }
    
    public function isEmpty(): bool
    {
        return empty($this->filters);
    }
    
    public function toQueryParam(): string
    {
        $params = [];
        foreach ($this->filters as $filter) {
            $params[$filter->getColumnName()] = $filter->toQueryParam();
        }
        
        return http_build_query($params, '', ';');
    }
    
    public function count(): int
    {
        return count($this->filters);
    }
    
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->filters);
    }
}
