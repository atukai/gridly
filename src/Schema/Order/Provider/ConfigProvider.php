<?php

namespace Gridly\Schema\Order\Provider;

use Gridly\Schema\Order\Exception;
use Gridly\Schema\Order\Order;

class ConfigProvider implements Provider
{
    private array $config;
    
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    /**
     * @throws Exception
     */
    public function provide(): ?Order
    {
        $orders = $this->config['schema']['order'];
        if (empty($orders)) {
            return null;
        }
        
        foreach ($orders as $column => $direction) {
            $order = new Order($column, $direction);
        }
        
        return $order;
    }
}
