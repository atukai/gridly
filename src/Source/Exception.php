<?php

namespace Gridly\Source;

class Exception extends \Gridly\Exception
{
    public static function sourceClassNotProvided(): Exception
    {
        return new self('Source class was not provided.');
    }
    
    public static function unsupportedSourceClass(string $className): Exception
    {
        return new self(sprintf('Unknown source class "%s".', $className));
    }
}
