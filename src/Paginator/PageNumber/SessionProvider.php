<?php

namespace Gridly\Paginator\PageNumber;

use Psr\Http\Message\ServerRequestInterface;

class SessionProvider implements Provider
{
    private ?string $paramName;
    
    public function __construct(?string $paramName = null)
    {
        $this->paramName = $paramName ?? self::PAGE_KEY;
    }
    
    public function provide(): int
    {
        return isset($_SESSION[$this->paramName]) ? (int)$_SESSION[$this->paramName] : self::PAGE_DEFAULT;
    }
}
