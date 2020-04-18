<?php

namespace App;

use App\Command\QueryWorldometersCommand;
use Symfony\Component\Console\Application;

const NAME = 'covid-19-data-scraper';
const VERSION = '0.2.0';

require __DIR__ . '/../vendor/autoload.php';

$app = new Application(NAME, VERSION);

$app->add(new QueryWorldometersCommand());

$app->run();
