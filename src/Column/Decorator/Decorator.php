<?php

namespace Gridly\Column\Decorator;

use Gridly\Column\Column;

interface Decorator
{
    /**
     * @param Column $column
     * @param array $additionalData
     * @return Column
     */
    public function __invoke(Column $column, array $additionalData = []): Column;
}