<?php

namespace Gridly\Test;

use Gridly\Column\Definitions;
use Gridly\Grid;
use Gridly\Paginator\Paginator;
use Gridly\Source\Source;
use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{
    private const DEFAULT_TITLE = 'Entries';
    
    public function testGridHasTitle(): void
    {
        $grid = $this->createGrid();
        self::assertEquals(self::DEFAULT_TITLE, $grid->getTitle());
    }
    
    public function testGridHasGivenTitle(): void
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
    
        return new Grid(self::DEFAULT_TITLE, $sourceMock, $definitionsMock, $paginatorMock);
    }
}
