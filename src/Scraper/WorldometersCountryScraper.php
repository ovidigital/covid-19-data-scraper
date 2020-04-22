<?php

namespace OviDigital\Covid19DataScraper\Scraper;

use OviDigital\Covid19DataScraper\Parser\ParserInterface;
use OviDigital\Covid19DataScraper\Parser\WorldometersCountryParser;
use OviDigital\Covid19DataScraper\Util\WorldometersUtil;

class WorldometersCountryScraper extends HttpScraper
{
    /** @var string The country code */
    protected $countryCode;

    /**
     * WorldometersCountryScraper constructor.
     *
     * @param string $countryCode
     * @param ParserInterface $parser
     */
    public function __construct(string $countryCode, ParserInterface $parser = null)
    {
        $this->countryCode = $countryCode;
        $this->url = WorldometersUtil::getCountryUrl($this->countryCode);
        $this->parser = $parser ?: new WorldometersCountryParser($countryCode);
    }
}
