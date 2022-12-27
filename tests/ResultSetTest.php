<?php

namespace Gridly\Test;

use Gridly\Column\Definitions;
use Gridly\Grid;
use Gridly\Storage;
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
        $storage = $this->createMock(Storage::class);
        $definitionsMock = $this->createMock(Definitions::class);

        return new Grid('Title', $storage, $definitionsMock);
    }

    protected function createGridWithData(): Grid
    {
        $storageMock = $this->createMock(Storage::class);
        $storageMock
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

        $definitionsMock = $this->createMock(Definitions::class);

        return new Grid('Title', $storageMock, $definitionsMock);
    }
}
