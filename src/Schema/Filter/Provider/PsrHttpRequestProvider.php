<?php

namespace Gridly\Schema\Filter\Provider;

use Gridly\Schema\Filter\Exception;
use Gridly\Schema\Filter\Filter;
use Gridly\Schema\Filter\FilterSet;
use Psr\Http\Message\ServerRequestInterface;

class PsrHttpRequestProvider implements Provider
{
    private const QUERY_PARAM = 'filters';
    
    private ServerRequestInterface $request;
    
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }
    
    /**
     * @throws Exception
     */
    public function provide(): FilterSet
    {
        $filters = new FilterSet();
        
        $queryParams = $this->request->getQueryParams();
        if (!isset($queryParams[self::QUERY_PARAM]) || empty($queryParams[self::QUERY_PARAM])) {
            return $filters;
        }
        $filterParams = explode(';', urldecode($queryParams[self::QUERY_PARAM]));
        
        foreach ($filterParams as $param) {
            $data = explode('=', $param);
            $filters->addFilter(Filter::fromQueryParam($data[0], $data[1]));
        }
        
        return $filters;
    }
}
