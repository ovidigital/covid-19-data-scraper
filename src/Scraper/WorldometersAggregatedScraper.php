<?php

namespace OviDigital\Covid19DataScraper\Scraper;

use OviDigital\Covid19DataScraper\Parser\ParserInterface;
use OviDigital\Covid19DataScraper\Parser\WorldometersAggregatedParser;

class WorldometersAggregatedScraper extends HttpScraper
{
    protected $url = 'https://www.worldometers.info/coronavirus/';

    protected $countryCodes = [];

    /**
     * WorldometersScraper constructor.
     *
     * @param array $countryCodes A list of country codes
     * @param ParserInterface $parser
     */
    public function __construct(array $countryCodes = [], ParserInterface $parser = null)
    {
        $this->countryCodes = $countryCodes;
        $this->parser = $parser ?: new WorldometersAggregatedParser($countryCodes);
    }
}
