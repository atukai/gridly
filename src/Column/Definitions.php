<?php

namespace Gridly\Column;

class Definitions
{
    /** @var Definition[] */
    private array $definitions;
    
    public function __construct()
    {
        $this->definitions = [];
    }
    
    public function add($columnName, Definition $definition): void
    {
        $this->definitions[$columnName] = $definition;
    }
    
    public function get($columnName): Definition
    {
        if (!array_key_exists($columnName, $this->definitions)) {
            return new Definition();
        }
        
        return $this->definitions[$columnName];
    }
}
