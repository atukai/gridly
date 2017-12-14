<?php

namespace DashboardTest;

use Dashboard\Grid;
use Dashboard\ResultSet;
use PHPUnit\Framework\TestCase;

class ResultSetTest extends TestCase
{
    public function testGridLoadReturnResultSet()
    {
        $grid = $this->createGrid();

        $result = $grid->getPageItems();
        $this->assertInstanceOf(ResultSet::class, $result);
    }

    public function testNotEmptyResultSetCount()
    {
        $grid = $this->createGrid();

        $result = $grid->getPageItems();
        $this->assertEquals($result->count(), 2);
    }

    public function testEmptyResultSetCount()
    {
        $grid = $this->createGrid();

        $result = $grid->getPageItems();
        $this->assertEquals($result->count(), 2);
    }

    /**
     * @return Grid
     */
    protected function createGrid()
    {
        $sourceMock = $this->getMockBuilder('Dashboard\Source\Pdo')
            ->setMethods(['getItems'])
            ->disableOriginalConstructor()
            ->getMock();

        $paginatorMock = $this->getMockBuilder('Dashboard\Paginator\Paginator')
            ->setMethods(['getPageItems', 'setItemsPerPage'])
            ->disableOriginalConstructor()
            ->getMock();

        $paginatorMock
            ->expects($this->once())
            ->method('getPageItems')
            ->will($this->returnValue(
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
            ));

        return new Grid($sourceMock, $paginatorMock);
    }
}
