<?php

namespace OviDigital\Covid19DataScraper\Command;

use OviDigital\Covid19DataScraper\Scraper\ScraperInterface;
use OviDigital\Covid19DataScraper\Util\CommandUtil;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueryCommand extends Command
{
    use CommandFilterTrait;

    protected $description = '';
    protected $helpText = '';
    protected $filters = [];
    protected $format = '';

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setDescription($this->description)
            ->setHelp($this->helpText);

        // Add country code option.
        CommandUtil::addCountryCodeOption($this);

        // Add output format option.
        CommandUtil::addOutputFormatOption($this);
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $countryCode = CommandUtil::validateCountryCodeOption($input);

        if ($countryCode) {
            $this->addCountryFilter($countryCode);
        }

        $format = CommandUtil::validateOutputFormatOption($input);

        if ($format) {
            $this->format = $format;
        }
    }

    /**
     * Output the scraped data.
     *
     * @param ScraperInterface $scraper
     */
    protected function output(ScraperInterface $scraper)
    {
        $scraper->scrape();
        $dataObject = $scraper->getDataObject();

        switch ($this->format) {
            case 'json':
                print $dataObject->getDataAsJson();
                break;
            case 'csv':
                print $dataObject->getDataAsCsv();
                break;

            default:
                print_r($dataObject->getData());
        }
    }
}
