<?php

namespace Gridly\Paginator\Pagerfanta;

use Gridly\Paginator\PaginatorFactory;
use Gridly\Source\Source;
use Pagerfanta\Pagerfanta;

class PagerfantaPaginatorFactory implements PaginatorFactory
{
    public function create(Source $source, array $options): PagerfantaPaginator
    {
        $paginator = new PagerfantaPaginator(
            new Pagerfanta(new PagerfantaPaginatorAdapter($source))
        );
        
        if (isset($options['itemsPerPage'])) {
            $paginator->setItemsPerPage($options['itemsPerPage']);
        }
        
        return $paginator;
    }
}
