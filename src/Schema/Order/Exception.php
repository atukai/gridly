<?php

namespace Gridly\Schema\Order;

class Exception extends \Gridly\Exception
{
    public static function onInvalidOrderDirection(string $direction): Exception
    {
        return new self('Invalid order direction "'. $direction . '" provided');
    }
}
