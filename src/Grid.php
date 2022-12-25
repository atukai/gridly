<?php

namespace Gridly;

use Gridly\Column\Definitions;
use Gridly\Paginator\PageNumber\Provider;
use Gridly\Paginator\Paginator;
use Gridly\Renderer\Renderer;
use Gridly\Source\Source;

class Grid
{
    /**
     * Grid title
     */
    private string $title;
    
    /**
     * Data source
     */
    private Source $source;
    
    /**
     * Data column definitions
     */
    private Definitions $columnDefinitions;
    
    /**
     * Paginator for paging data rows
     */
    private Paginator $paginator;
    
    public function __construct(string $title, Source $source, Definitions $columnDefinitions, Paginator $paginator)
    {
        $this->title = $title;
        $this->source = $source;
        $this->columnDefinitions = $columnDefinitions;
        $this->paginator = $paginator;
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
            $this->paginator->getPageItems($page),
            $this->columnDefinitions
        );
    }
    
    public function getSchemaFilterParams(): array
    {
        return $this->source->getSchema()->getParams();
    }
    
    public function getCurrentPage(): int
    {
        return $this->paginator->getCurrentPage();
    }
    
    public function getTotalPages(): int
    {
        return $this->paginator->getTotalPages();
    }
    
    public function getFoundItems(): int
    {
        return $this->source->count();
    }
    
    public function getTotalItems(): int
    {
        return $this->source->countAll();
    }
    
    public function render(Provider $pageNumberProvider, Renderer $renderer): ?string
    {
        return $renderer->render($this, $pageNumberProvider->provide());
    }
}
