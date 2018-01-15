<?php

namespace Gridly\Schema\Filter\Provider;

use Gridly\Schema\Filter\Filter;
use Gridly\Schema\Filter\FilterSet;

class ConfigProvider implements Provider
{
    private array $config;
    
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    public function provide(): FilterSet
    {
        $filters = new FilterSet();
        if (!empty($this->config)) {
            foreach ($this->config as $field => $filter) {
                $filters->addFilter(new Filter($field, $filter['operand'], $filter['value']));
            }
        }
        
        return $filters;
    }
}
