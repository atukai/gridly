<?php

namespace Gridly\Column\Decorator;

use DateTime;
use Gridly\Column\Column;

class HyperLink implements Decorator
{
    protected string $url = '#';
    
    public function __construct($url)
    {
        $this->url = $url;
    }
    
    public function __invoke(Column $column, array $additionalData = []): Column
    {
        $params = [];
        $values = [];
        
        foreach ($additionalData as $key => $val) {
            $params[] = '%'. $key .'%';
            $values[] = $val;
        }
        
        // Convert objects to string type
        foreach ($values as $i => $value) {
            if ($value instanceof DateTime) {
                $values[$i] = $value->format(DATE_COOKIE);
            }
        }
        
        $url = str_replace($params, $values, $this->url);
        
        
        return $column->withValue('<a href="' . $url . '">' . $column->value() . '</a>');
    }
}
