<?php

use Core\Services\Services;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project
require_once 'Core/Services/Services.php';
require_once 'Core/Config/env.php';

$services = new Services();
$entityManager = $services->getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);

//vendor\bin\doctrine orm:schema-tool:update --force --dump-sql
//vendor\bin\doctrine dbal:import data.sql