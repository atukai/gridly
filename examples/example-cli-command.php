<?php

use Gridly\Command\GridlyCommand;
use Gridly\Paginator\Laminas\LaminasPaginatorFactory;
use Symfony\Component\Console\Application;

include '../vendor/autoload.php';

// APPLICATION
$application = new Application('Gridly Example', '0.0.1');
$application->add(new GridlyCommand(new LaminasPaginatorFactory()));
$application->run();
