<?php

namespace Gridly\Test;

use Gridly\Column\Definitions;
use Gridly\Grid;
use Gridly\Paginator\PageNumber\Provider;
use Gridly\Renderer\Renderer;
use Gridly\Storage;
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

    public function testRender(): void
    {
        $renderer = $this->createMock(Renderer::class);
        $renderer->expects($this->once())->method('render');

        $grid = $this->createGrid();
        $grid->render($this->createMock(Provider::class), $renderer);
    }

    private function createGrid(
        string $title = null,
        Storage $storage = null,
        Definitions $definitions = null
    ): Grid {
        $title = $title ?? self::DEFAULT_TITLE;
        $storage = $storage ?? $this->createMock(Storage::class);
        $definitions = $definitions ?? $this->createMock(Definitions::class);

        return new Grid($title, $storage, $definitions);
    }
}
