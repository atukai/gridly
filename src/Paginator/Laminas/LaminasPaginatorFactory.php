<?php

namespace Gridly\Paginator\Laminas;

use Gridly\Paginator\PaginatorFactory;
use Gridly\Source\Source;
use Laminas\Paginator\Paginator;

class LaminasPaginatorFactory implements PaginatorFactory
{
    public static function create(Source $source, array $options): LaminasPaginator
    {
        $paginator = new LaminasPaginator(
            new Paginator(new LaminasPaginatorAdapter($source))
        );
    
        if (isset($options['itemsPerPage'])) {
            $paginator->setItemsPerPage($options['itemsPerPage']);
        }
        
        return $paginator;
    }
}
