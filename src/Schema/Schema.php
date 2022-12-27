<?php

namespace Gridly\Schema;

use Gridly\Schema\Filter\FilterSet;
use Gridly\Schema\Order\Order;

class Schema
{
    private FilterSet $filters;
    private Order|null $order;
    
    /**
     * @param FilterSet $filters
     * @param Order|null $order
     */
    public function __construct(FilterSet $filters, ?Order $order = null)
    {
        $this->filters = $filters;
        $this->order = $order;
    }
    
    public function getOrder(): ?Order
    {
        return $this->order;
    }
    
    public function getFilters(): FilterSet
    {
        return $this->filters;
    }
    
    public function toArray(): array
    {
        $params['filters'] = $this->getFilters()->toQueryParam();
        $params['order'] = $this->getOrder()?->toQueryParam();
        return $params;
    }
}
