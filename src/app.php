<?php

namespace App;

use Symfony\Component\Console\Application;

const NAME = 'covid-19-data-scraper';
const VERSION = '0.1.0';

require __DIR__ . '/../vendor/autoload.php';

$app = new Application(NAME, VERSION);

$app->run();
