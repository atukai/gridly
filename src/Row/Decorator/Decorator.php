<?php

namespace Gridly\Row\Decorator;

use Gridly\Row\Row;

interface Decorator
{
    public function __invoke(Row $row, array $additionalData = []): Row;
}
