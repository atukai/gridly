<?php

namespace Gridly\Paginator\PageNumber;

use Psr\Http\Message\ServerRequestInterface;

class PsrHttpRequestAttributeProvider implements Provider
{
    private ServerRequestInterface $request;
    private ?string $attributeName;
    
    public function __construct(ServerRequestInterface $request, ?string $attributeName = null)
    {
        $this->request = $request;
        $this->attributeName = $attributeName ?? self::PAGE_KEY;
    }
    
    public function provide(): int
    {
        return $this->request->getAttribute($this->attributeName, self::PAGE_DEFAULT);
    }
}
