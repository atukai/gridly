<?php

namespace Gridly\Column;

class Column
{
    private string $name;
    private mixed $value;
    private ?Type $type;
    private string $label;
    private bool $isSortable;
    private bool $isFilterable;
    private ?bool $isVisible;
    
    public function __construct(
        string $name,
        mixed $value,
        ?Type $type = null,
        ?string $label = null,
        ?bool $isSortable = false,
        ?bool $isFilterable = false,
        ?bool $isVisible = false
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
        $this->label = $label ?? $name;
        $this->isSortable = $isSortable;
        $this->isFilterable = $isFilterable;
        $this->isVisible = $isVisible;
    }
    
    public function name(): string
    {
        return $this->name;
    }

    public function value(): mixed
    {
        return $this->castType($this->value);
    }
    
    public function type(): Type
    {
        return $this->type;
    }
    
    public function label(): string
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
    
    public function withValue(mixed $value): Column
    {
        $new = clone $this;
        $new->setValue($value);
        
        return $new;
    }
    
    public function withType(Type $type): Column
    {
        $new = clone $this;
        $new->setType($type);
        
        return $new;
    }
    
    private function setValue(mixed $value): void
    {
        $this->value = $value;
    }
    
    private function setType(Type $type): void
    {
        $this->type = $type;
    }
    
    private function castType($value)
    {
        if (null === $value) {
            return null;
        }
        
        if (!$this->type) {
            return $value;
        }
        
        return match ($this->type) {
            Type::STRING => (string)$value,
            Type::INTEGER => (int)$value,
            Type::BOOLEAN => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            default => $value,
        };
    }
}
