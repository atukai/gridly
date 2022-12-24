<?php

namespace Gridly\Column;

use Gridly\Column\Decorator\DecoratorPipeline;

class Definition
{
    private Type $type;
    private string $label;
    private bool $isSortable;
    private bool $isFilterable;
    private bool $isVisible;
    
    private DecoratorPipeline $decorators;
    
    public function __construct(
        ?Type $type = null,
        ?string $label = '',
        ?bool $isSortable = false,
        ?bool $isFilterable = false,
        ?bool $isVisible = false
    ) {
        $this->type = $type ?? Type::STRING;
        $this->label = $label;
        $this->isSortable = $isSortable;
        $this->isFilterable = $isFilterable;
        $this->isVisible = $isVisible;
        
        $this->decorators = new DecoratorPipeline();
    }

    public static function fromArray(array $data): Definition
    {
        return new self(
            self::type($data),
            self::label($data),
            self::sortable($data),
            self::filterable($data),
            self::visible($data)
        );
    }
    
    public function getType(): Type
    {
        return $this->type;
    }
    
    public function getLabel(): string
    {
        return $this->label;
    }
    
    public function isSortable(): bool
    {
        return $this->isSortable;
    }
    
    public function isFilterable(): bool
    {
        return $this->isFilterable;
    }
    
    public function isVisible(): bool
    {
        return $this->isVisible;
    }
    
    public function addColumnDecorator(callable $decorator): void
    {
        $this->decorators->pipe($decorator);
    }
    
    public function getDecorators(): DecoratorPipeline
    {
        return $this->decorators;
    }
    
    private static function type(?array $data = []): ?Type
    {
        return isset($data['type']) ? Type::from($data['type']) : null;
    }
    
    private static function label(?array $data = []): string
    {
        return $data['label'] ?? '';
    }
    
    private static function sortable(?array $data = []): bool
    {
        return isset($data['sortable']) && $data['sortable'];
    }
    
    private static function filterable(?array $data = []): bool
    {
        return isset($data['filterable']) && $data['filterable'];
    }
    
    private static function visible(?array $data = []): bool
    {
        return !isset($data['visible']) || $data['visible'];
    }
}
