<?php

use Gridly\Command\SymfonyConsoleCommand;
use Symfony\Component\Console\Application;

include '../vendor/autoload.php';

// COMMANDS
$gridlyCommand = new SymfonyConsoleCommand();

// APPLICATION
$application = new Application('Gridly Example', '0.0.1');
$application->add($gridlyCommand);
$application->setDefaultCommand($gridlyCommand->getName(), true);
$application->run();
