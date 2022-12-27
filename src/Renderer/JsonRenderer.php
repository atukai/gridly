<?php

namespace Gridly\Renderer;

use Gridly\Grid;
use JsonException;

class JsonRenderer implements Renderer
{
    /**
     * @throws JsonException
     */
    public function render(Grid $grid, int $page): string
    {
        $data = [
            'rows' => $grid->getPageItems($page),
            'totalItems' => $grid->getTotalItems(),
            'page' => $page,
            'totalPages' => $grid->getTotalPages()
        ];

        return json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }
}
