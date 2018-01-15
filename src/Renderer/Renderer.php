<?php

namespace Gridly\Renderer;

use Gridly\Grid;

interface Renderer
{
    public function render(Grid $grid, int $page): ?string;
}
