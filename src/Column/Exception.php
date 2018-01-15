<?php

namespace Gridly\Column;

class Exception extends \Gridly\Exception
{
    public static function columnDefinitionsNotFound(): Exception
    {
        return new self('Column definitions not found.');
    }
    
    public static function columnDefinitionNotFound(string $columnName): Exception
    {
        return new self(sprintf('Definition for column "%s" not found.', $columnName));
    }
}
