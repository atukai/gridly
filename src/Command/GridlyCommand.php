<?php

namespace Gridly\Command;

use Gridly\GridFactory;
use Gridly\Paginator\PageNumber\SymfonyConsoleOptionProvider;
use Gridly\Paginator\PaginatorFactory;
use Gridly\Renderer\SymfonyConsoleTableRenderer;
use Gridly\Schema\Order\Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'gridly',
    description: 'Print list of entries.',
    aliases: ['gridly:list']
)]
class GridlyCommand extends Command
{
    private PaginatorFactory $paginatorFactory;

    public function __construct(PaginatorFactory $paginatorFactory, string $name = null)
    {
        $this->paginatorFactory = $paginatorFactory;
        parent::__construct($name);
    }

    public function configure(): void
    {
        $this->addArgument('schema', InputArgument::REQUIRED, 'Grid schema file.')
            ->addOption('page', 'p', InputOption::VALUE_REQUIRED, 'Page number to display.', 1);
    }

    /**
     * @throws Exception
     * @throws \Gridly\Schema\Filter\Exception
     * @throws \Gridly\Source\Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $grid = GridFactory::fromYaml($input->getArgument('schema'), $this->paginatorFactory);
        $grid->render(new SymfonyConsoleOptionProvider($input), new SymfonyConsoleTableRenderer($output));

        return Command::SUCCESS;
    }
}
