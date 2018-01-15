<?php

namespace Gridly\Column\Decorator;

use Gridly\Column\Column;
use Gridly\Column\Type;

class HtmlTagDecorator implements Decorator
{
    private string $tag;
    private array $attributes;
    private bool $wrapValue;
    
    public function __construct(string $tag, array $attributes = [], bool $wrapValue = true)
    {
        $this->tag = $tag;
        $this->attributes = $attributes;
        $this->wrapValue = $wrapValue;
    }

    public function __invoke(Column $column, array $additionalData = []): Column
    {
        $attrHtml = '';
        foreach ($this->attributes as $name => $value) {
            $attrHtml .= ' ' . $name . '="' . $value . '"';
        }
        
        $value = $this->wrapValue ? $column->value() : '';
        $html = sprintf('<%s%s>' . $value . '</%s>', $this->tag, $attrHtml, $this->tag);
        
        return $column
            ->withValue($html)
            ->withType(Type::STRING);
    }
}
