<?php

namespace DashboardTest;

use Dashboard\Grid;
use Dashboard\Source\Pdo;
use PHPUnit\Framework\TestCase;

class GridPdoTest extends TestCase
{
    public function testGridCreation()
    {
        /** @var Pdo $source */
        $sourceMock = $this->createMock('Dashboard\Source\AbstractSource');
        $paginatorMock = $this->createMock('Dashboard\Paginator\Paginator');

        $grid = new Grid($sourceMock, $paginatorMock);

        $this->assertInstanceOf(Grid::class, $grid);
    }
}
