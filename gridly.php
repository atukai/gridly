<?php

use Gridly\Factory;
use Gridly\Renderer\SymfonyConsoleCommandRenderer;
use Symfony\Component\Console\Application;

include 'vendor/autoload.php';

$grid = Factory::create('gridly.yml');

// COMMANDS
$listCommand = new SymfonyConsoleCommandRenderer($grid);

// APPLICATION
$application = new Application('Gridly', '0.5.0');
$application->add($listCommand);
$application->setDefaultCommand($listCommand->getName());
$application->run();
