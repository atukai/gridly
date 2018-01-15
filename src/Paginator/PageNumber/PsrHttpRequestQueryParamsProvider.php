<?php

namespace Gridly\Paginator\PageNumber;

use Psr\Http\Message\ServerRequestInterface;

class PsrHttpRequestQueryParamsProvider implements Provider
{
    private ServerRequestInterface $request;
    private ?string $paramName;
    
    public function __construct(ServerRequestInterface $request, ?string $paramName = null)
    {
        $this->request = $request;
        $this->paramName = $paramName ?? self::PAGE_KEY;
    }
    
    public function provide(): int
    {
        $queryParams = $this->request->getQueryParams();
        return isset($queryParams[$this->paramName]) ? (int)$queryParams[$this->paramName] : self::PAGE_DEFAULT;
    }
}
