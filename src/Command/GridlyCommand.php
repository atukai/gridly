<?php

namespace Gridly\Command;

use Gridly\Factory;
use Gridly\Paginator\Laminas\LaminasPaginatorFactory;
use Gridly\Paginator\PageNumber\SymfonyConsoleOptionProvider;
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
            ->addOption('page', 'p', InputOption::VALUE_OPTIONAL, 'Page number to display.', 1);
    }
    
    /**
     * @throws Exception
     * @throws \Gridly\Schema\Filter\Exception
     * @throws \Gridly\Source\Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $grid = Factory::fromYaml($input->getArgument('schema'), new LaminasPaginatorFactory());
        $grid->render(new SymfonyConsoleOptionProvider($input), new SymfonyConsoleTableRenderer($output));
        
        return Command::SUCCESS;
    }
}
