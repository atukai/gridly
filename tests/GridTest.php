<?php

namespace Gridly\Test;

use Gridly\Grid;
use Gridly\Paginator\Paginator;
use Gridly\Schema\Schema;
use Gridly\Source\Source;
use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{
    public function testGetPageItemsMultipleTimes(): void
    {
        $grid = $this->createGrid();
        self::assertNotNull($grid->getPageItems());
        self::assertNotNull($grid->getPageItems());
    }
    
    private function createGrid(): Grid
    {
        $sourceMock = $this->createMock(Source::class);
        $paginatorMock = $this->createMock(Paginator::class);
    
        return new Grid($sourceMock, $paginatorMock);
    }
}
