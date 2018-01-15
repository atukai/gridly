<?php

namespace Gridly\Schema\Filter;

class Filter
{
    public const OP_EQUAL            = 'eq';
    public const OP_NOT_EQUAL        = '!eq';
    public const OP_GREATER          = 'gt';
    public const OP_GREATER_OR_EQUAL = 'gte';
    public const OP_LESS             = 'lt';
    public const OP_LESS_OR_EQUAL    = 'lte';
    public const OP_LIKE             = 'l';
    public const OP_LIKE_LEFT        = 'll';
    public const OP_LIKE_RIGHT       = 'lr';
    public const OP_NOT_LIKE         = '!l';
    public const OP_NOT_LIKE_LEFT    = '!ll';
    public const OP_NOT_LIKE_RIGHT   = '!lr';
    public const OP_IN               = 'in';
    public const OP_NOT_IN           = '!in';
    public const OP_BETWEEN          = 'btw';
    
    private const QUERY_PARAM_SEPARATOR = ':';

    private string $columnName;
    private string $operand;
    private mixed $value;

    /**
     * @param string $columnName
     * @param string $operand
     * @param mixed  $value
     */
    public function __construct(string $columnName, string $operand, mixed $value)
    {
        $this->columnName = $columnName;
        $this->operand = $operand;
        $this->value = $value;
    }
    
    /**
     * @throws Exception
     */
    public static function fromQueryParam(string $name, string $queryParam): Filter
    {
        $params = explode(self::QUERY_PARAM_SEPARATOR, $queryParam);
        if (count($params) !== 2) {
            throw Exception::invalidQueryParam($queryParam);
        }
    
        return new self($name, $params[0], $params[1]);
    }

    /**
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }

    public function getOperand(): string
    {
        return $this->operand;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
    
    public function toQueryParam(): string
    {
        return $this->getOperand() . self::QUERY_PARAM_SEPARATOR . $this->getValue();
    }
}
