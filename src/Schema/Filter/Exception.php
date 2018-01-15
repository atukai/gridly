<?php

namespace Gridly\Schema\Filter;

class Exception extends \Gridly\Exception
{
    /**
     * @param string $operand
     * @param string $source
     * @return Exception
     */
    public static function unsupportedFilterOperand(string $operand, string $source): Exception
    {
        return new self('Operand "'. $operand . '" not supported for source ' . $source);
    }
    
    /**
     * @param string $param
     * @return Exception
     */
    public static function invalidQueryParam(string $param): Exception
    {
        return new self('Can\'t create Filter from invalid param ' . $param);
    }
}
