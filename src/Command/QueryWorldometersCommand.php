<?php

namespace OviDigital\Covid19DataScraper\Command;

use OviDigital\Covid19DataScraper\Scraper\WorldometersCountryScraper;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueryWorldometersCommand extends QueryCommand {
    protected static $defaultName = 'query:wm';

    protected $description = 'Queries www.worldometers.info/coronavirus';

  /**
   * Executes command.
   */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $countryCode = $this->getCountryFilter();

        if ($countryCode) {
            $scraper = new WorldometersCountryScraper($countryCode);
            $this->output($scraper);
        }
        else {
            throw new InvalidOptionException('Please use the --country option.');
        }

        return 0;
    }
}
