<?php

namespace Gridly\Test;

use Gridly\Column\Definitions;
use Gridly\Grid;
use Gridly\Paginator\Paginator;
use Gridly\Schema\Schema;
use Gridly\Source\Source;
use PHPUnit\Framework\TestCase;

class ResultSetTest extends TestCase
{
    public function testEmptyResultSetCount(): void
    {
        $grid = $this->createGrid();
        
        $result = $grid->getPageItems();
        self::assertEquals(0, $result->count());
    }
    
    public function testNotEmptyResultSetCount(): void
    {
        $grid = $this->createGridWithData();

        $result = $grid->getPageItems();
        self::assertEquals(2, $result->count());
    }
    
    protected function createGrid(): Grid
    {
        $paginatorMock = $this->createMock(Paginator::class);
        $definitionsMock = $this->createMock(Definitions::class);
        $sourceMock = $this->createMock(Source::class);
        
        return new Grid('Title', $sourceMock, $definitionsMock, $paginatorMock);
    }
    
    protected function createGridWithData(): Grid
    {
        $paginatorMock = $this->createMock(Paginator::class);
        $paginatorMock
            ->expects(self::once())
            ->method('getPageItems')
            ->willReturn(
                [
                    [
                        'id' => 1,
                        'name' => 'Aaron Turmonen',
                        'email' => 'aaron@example.com'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Lewis Skorski',
                        'email' => 'lewis@example.com'
                    ]
                ]
            );

        $sourceMock = $this->createMock(Source::class);
        $definitionsMock = $this->createMock(Definitions::class);

        return new Grid('Title', $sourceMock, $definitionsMock, $paginatorMock);
    }
}
