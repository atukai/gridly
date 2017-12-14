<?php

namespace Dashboard;

class Column
{
    private $name;
    private $value;

    /**
     * @param string $name
     * @param $value
     */
    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
