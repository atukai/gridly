<?php

namespace Gridly;

use Gridly\Column\Decorator\DecoratorPipeline;
use Gridly\Column\Definitions;
use Gridly\Paginator\PageNumber\Provider;
use Gridly\Paginator\Paginator;
use Gridly\Renderer\Renderer;
use Gridly\Source\Source;

class Grid
{
    /**
     * Data source
     */
    private Source $source;
    
    /**
     * Data column definitions
     */
    private Definitions $columnDefinitions;
    
    /**
     * Data column decorators
     *
     * @var array<string, DecoratorPipeline>
     */
    private array $columnDecorators;
    
    /**
     * Paginator for paging data rows
     */
    private Paginator $paginator;
    
    public function __construct(Source $source, Definitions $columnDefinitions, Paginator $paginator)
    {
        $this->source = $source;
        $this->columnDefinitions = $columnDefinitions;
        $this->columnDecorators = [];
        $this->paginator = $paginator;
    }
    
    /**
     * @throws Column\Exception
     */
    public function getPageItems(?int $page = 1): ResultSet
    {
        return new ResultSet(
            $this->paginator->getPageItems($page),
            $this->columnDefinitions,
            $this->columnDecorators
        );
    }
    
    public function addColumnDecorator(string $columnName, callable $decorator): Grid
    {
        if (!isset($this->columnDecorators[$columnName])) {
            $this->columnDecorators[$columnName] = new DecoratorPipeline();
        }

        /** @var DecoratorPipeline $pipeline */
        $pipeline = $this->columnDecorators[$columnName];
        $pipeline->pipe($decorator);

        return $this;
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
    
    public function render(Provider $pageNumberProvider, Renderer $renderer): string
    {
        return $renderer->render($this, $pageNumberProvider->provide());
    }
}
