<?php

namespace OviDigital\Covid19DataScraper;

use OviDigital\Covid19DataScraper\Command\QueryWorldometersCommand;
use Symfony\Component\Console\Application;

const NAME = 'covid-19-data-scraper';
const VERSION = '0.3.0';

require __DIR__ . '/../vendor/autoload.php';

$app = new Application(NAME, VERSION);

$app->add(new QueryWorldometersCommand());

$app->run();
