<?php

namespace Gridly\Schema;

use Gridly\Schema\Filter\Provider\ConfigProvider;
use Gridly\Schema\Filter\Provider\PsrHttpRequestProvider;
use Psr\Http\Message\ServerRequestInterface;

class Factory
{
    /**
     * @throws Filter\Exception
     * @throws Order\Exception
     */
    public static function create(array $config, ?ServerRequestInterface $request = null): Schema
    {
        $configFiltersProvider = new ConfigProvider($config['schema']['filters'] ?? []);
        $filters = $configFiltersProvider->provide();
    
        $order = null;
        if ($request) {
            $psrHttpRequestFiltersProvider = new PsrHttpRequestProvider($request);
            $filters->merge($psrHttpRequestFiltersProvider->provide());
    
            $order = (new Order\Provider\PsrHttpRequestProvider($request))->provide() ??
                (new Order\Provider\ConfigProvider($config))->provide();
        }
        
        
        return new Schema($filters, $order);
    }
}
