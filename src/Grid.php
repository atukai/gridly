<?php

namespace Gridly;

use Gridly\Column\Definitions;
use Gridly\Paginator\PageNumber\Provider;
use Gridly\Renderer\Renderer;

class Grid
{
    /**
     * Grid title
     */
    private string $title;

    /**
     * Data storage/repository. Includes source and paginator
     */
    private Storage $storage;

    /**
     * Data column definitions
     */
    private Definitions $columnDefinitions;

    public function __construct(string $title, Storage $storage, Definitions $columnDefinitions)
    {
        $this->title = $title;
        $this->storage = $storage;
        $this->columnDefinitions = $columnDefinitions;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPageItems(int $page = 1): ResultSet
    {
        return new ResultSet(
            $this->storage->getPageItems($page),
            $this->columnDefinitions
        );
    }

    public function getSchemaParams(): array
    {
        return $this->storage->getSchemaParams();
    }

    public function getCurrentPage(): int
    {
        return $this->storage->getCurrentPage();
    }

    public function getTotalPages(): int
    {
        return $this->storage->getTotalPages();
    }

    public function countFoundItems(): int
    {
        return $this->storage->count();
    }

    public function getTotalItems(): int
    {
        return $this->storage->countAll();
    }

    public function render(Provider $pageNumberProvider, Renderer $renderer): ?string
    {
        return $renderer->render($this, $pageNumberProvider->provide());
    }
}
