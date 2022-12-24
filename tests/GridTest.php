<?php

namespace Gridly\Test;

use Gridly\Column\Definitions;
use Gridly\Grid;
use Gridly\Paginator\Paginator;
use Gridly\Source\Source;
use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{
    public function testGridHasDefaultTitle(): void
    {
        $grid = $this->createGrid();
        self::assertEquals('Entries', $grid->getTitle());
    }
    
    public function testGridReturnGivenTitle(): void
    {
        $grid = $this->createGrid();
        $grid->setTitle('Title');
        self::assertEquals('Title', $grid->getTitle());
    }
    
    public function testGetPageItemsMultipleTimes(): void
    {
        $grid = $this->createGrid();
        self::assertNotNull($grid->getPageItems());
        self::assertNotNull($grid->getPageItems());
    }
    
    private function createGrid(): Grid
    {
        $sourceMock = $this->createMock(Source::class);
        $definitionsMock = $this->createMock(Definitions::class);
        $paginatorMock = $this->createMock(Paginator::class);
    
        return new Grid($sourceMock, $definitionsMock, $paginatorMock);
    }
}
