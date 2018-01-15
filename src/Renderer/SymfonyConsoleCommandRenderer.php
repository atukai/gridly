<?php

namespace Gridly\Renderer;

use Gridly\Column\Column;
use Gridly\Grid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SymfonyConsoleCommandRenderer extends Command
{
    protected static $defaultName = 'list';
    
    /** @var Grid */
    private $grid;
    
    /**
     * @param Grid $grid
     * @param string|null $name
     */
    public function __construct(Grid $grid, string $name = null)
    {
        $this->grid = $grid;
        parent::__construct($name);
    }

    public function configure(): void
    {
        $this->setDescription('List of entries.')
            ->setHelp('Print a list of entries')
            ->addArgument('page', InputArgument::OPTIONAL, 'Page to display.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $page = 1;
        if ($input->getArgument('page')) {
            $page = $input->getArgument('page');
        }
        
        $data = $this->grid->getPageItems($page, ['step_number']);
    
        $table = new Table($output);
        $table->setHeaders($data->getHeaders());

        foreach ($data as $row) {
            $rowData = [];
            /** @var Column $column */
            foreach ($row as $column) {
                $rowData[] = $column->value();
            }
            $table->addRow($rowData);
        }
    
        $table->setHeaderTitle(sprintf('Entries: %d/%d', count($data), $this->grid->getTotalItems()));
        $table->setFooterTitle(sprintf('Page: %d/%d', $page, $this->grid->getTotalPages()));
        $table->render();
        
        return Command::SUCCESS;
    }
}
