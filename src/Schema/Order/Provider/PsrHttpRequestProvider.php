<?php

namespace Gridly\Schema\Order\Provider;

use Gridly\Schema\Order\Exception;
use Gridly\Schema\Order\Order;
use Psr\Http\Message\ServerRequestInterface;

class PsrHttpRequestProvider implements Provider
{
    private const QUERY_PARAM = 'order';
    
    private ServerRequestInterface $request;
    
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }
    
    /**
     * @throws Exception
     */
    public function provide(): ?Order
    {
        $queryParams = $this->request->getQueryParams();
        if (!isset($queryParams[self::QUERY_PARAM]) || empty($queryParams[self::QUERY_PARAM])) {
            return null;
        }
        
        $data = explode('~', $queryParams[self::QUERY_PARAM]);
    
        return new Order($data[0], $data[1]);
    }
}
