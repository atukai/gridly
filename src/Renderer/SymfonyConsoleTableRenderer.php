<?php

namespace Gridly\Renderer;

use Gridly\Column\Column;
use Gridly\Column\Exception;
use Gridly\Grid;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class SymfonyConsoleTableRenderer implements Renderer
{
    private OutputInterface $output;
    
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }
    
    /**
     * @throws Exception
     */
    public function render(Grid $grid, int $page): ?string
    {
        $data = $grid->getPageItems($page);
    
        $table = new Table($this->output);
        $table->setHeaders($data->getHeadersRow()->getNames());
    
        foreach ($data as $row) {
            $rowData = [];
            /** @var Column $column */
            foreach ($row as $column) {
                $rowData[] = $column->value();
            }
            $table->addRow($rowData);
        }
    
        $table->setHeaderTitle(sprintf('Entries: %d/%d', count($data), $grid->getTotalItems()));
        $table->setFooterTitle(sprintf('Page: %d/%d', $page, $grid->getTotalPages()));
        $table->render();
        
        return null;
    }
}
