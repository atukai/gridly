<?php

namespace Gridly\Paginator\PageNumber;

use Psr\Http\Message\ServerRequestInterface;

class CookieProvider implements Provider
{
    private ?string $cookieName;
    
    public function __construct(?string $cookieName = null)
    {
        $this->cookieName = $cookieName ?? self::PAGE_KEY;
    }
    
    public function provide(): int
    {
        return isset($_COOKIE[$this->cookieName]) ? (int)$_COOKIE[$this->cookieName] : self::PAGE_DEFAULT;
    }
}
