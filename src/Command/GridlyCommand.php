<?php

namespace Gridly\Command;

use Gridly\Factory;
use Gridly\Paginator\Laminas\LaminasPaginatorFactory;
use Gridly\Renderer\SymfonyConsoleTableRenderer;
use Gridly\Schema\Order\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GridlyCommand extends Command
{
    protected static $defaultName = 'gridly';
    
    public function configure(): void
    {
        $this->setDescription('List of entries.')
            ->setHelp('Print a list of entries')
            ->addArgument('schema', InputArgument::REQUIRED, 'Grid schema file.')
            ->addOption('page', 'p', InputOption::VALUE_REQUIRED, 'Page number to display.');
    }
    
    /**
     * @throws Exception
     * @throws \Gridly\Source\Exception
     * @throws \Gridly\Schema\Filter\Exception
     * @throws \Gridly\Column\Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $schemaFile = $input->getArgument('schema');
        
        $grid = Factory::fromYaml($schemaFile, new LaminasPaginatorFactory());
        
        $page = 1;
        if ($input->getOption('page')) {
            $page = $input->getOption('page');
        }
    
        $renderer = new SymfonyConsoleTableRenderer($output);
        $renderer->render($grid, $page);
        
        return Command::SUCCESS;
    }
}
