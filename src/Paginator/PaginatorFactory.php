<?php

namespace Gridly\Paginator;

use Gridly\Source\Source;

interface PaginatorFactory
{
    public function create(Source $source, array $options): Paginator;
}
