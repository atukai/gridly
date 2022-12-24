<?php

use Gridly\Command\GridlyCommand;
use Symfony\Component\Console\Application;

include '../vendor/autoload.php';

// COMMANDS
$gridlyCommand = new GridlyCommand();

// APPLICATION
$application = new Application('Gridly Example', '0.0.1');
$application->add($gridlyCommand);
$application->setDefaultCommand($gridlyCommand->getName(), true);
$application->run();
