<?php

namespace Gridly\Paginator\PageNumber;

interface Provider
{
    public const PAGE_KEY = 'page';
    public const PAGE_DEFAULT = 1;
    
    public function provide(): int;
}