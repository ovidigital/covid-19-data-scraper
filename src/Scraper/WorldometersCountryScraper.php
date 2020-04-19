<?php

namespace App\Scraper;

use App\Parser\ParserInterface;
use App\Parser\WorldometersCountryParser;
use App\Util\WorldometersUtil;

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
        $this->parser = $parser ?: new WorldometersCountryParser($countryCode);
        $this->countryCode = $countryCode;
        $this->url = WorldometersUtil::getCountryUrl($this->countryCode);
    }
}
