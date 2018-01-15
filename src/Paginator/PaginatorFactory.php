<?php

namespace Gridly\Paginator;

use Gridly\Source\Source;

interface PaginatorFactory
{
    public static function create(Source $source, array $options): Paginator;
}
