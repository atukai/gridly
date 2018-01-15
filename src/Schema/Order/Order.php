<?php

namespace Gridly\Schema\Order;

use function in_array;

class Order
{
    public const DIRECTION_ASC = 'asc';
    public const DIRECTION_DESC = 'desc';
    
    private string $columnName;
    private string $direction;
    private array $directions = [self::DIRECTION_ASC, self::DIRECTION_DESC];
    
    /**
     * @param string $columnName
     * @param string $direction
     * @throws Exception
     */
    public function __construct(string $columnName, string $direction)
    {
        $this->columnName = $columnName;

        $direction = strtolower($direction);
        if (!in_array($direction, $this->directions, true)) {
            throw Exception::onInvalidOrderDirection($direction);
        }
        $this->direction = $direction;
    }

    public function getColumnName(): string
    {
        return $this->columnName;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }
    
    public function toQueryParam(): string
    {
        return $this->getColumnName() . '~' . $this->getDirection();
    }
    
    public function toInvertedQueryParams(): string
    {
        return $this->getColumnName() . '~' . $this->getInvertedDirection();
    }
    
    private function getInvertedDirection(): string
    {
        return ($this->getDirection() === self::DIRECTION_ASC) ? self::DIRECTION_DESC : self::DIRECTION_ASC;
    }
}
