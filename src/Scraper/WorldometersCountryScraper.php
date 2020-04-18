<?php

namespace App\Scraper;

use App\Util\WorldometersUtil;
use League\ISO3166\ISO3166;
use Symfony\Component\CssSelector\Exception\ParseException;
use Symfony\Component\DomCrawler\Crawler;

class WorldometersCountryScraper extends HttpScraper
{
    /**
     * @var string The country code.
     */
    protected $countryCode;

    /**
     * WorldometersCountryScraper constructor.
     *
     * @param array $filter
     */
    public function __construct(array $filter)
    {
        $this->countryCode = $filter['country'];

        $this->url = WorldometersUtil::getCountryUrl($this->countryCode);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $content = $this->getContent();

        $crawler = new Crawler($content);

        $totalStatsRaw = $crawler->filter('#maincounter-wrap .maincounter-number')->each(function (Crawler $node) {
            return $node->text();
        });

        if (empty($totalStatsRaw) || count($totalStatsRaw) !== 3) {
            throw new ParseException('Cannot parse data');
        }

        $totalStats = [
            'cases' => preg_replace('/\D/', '', $totalStatsRaw[0]),
            'deaths' => preg_replace('/\D/', '', $totalStatsRaw[1]),
            'recovered' => preg_replace('/\D/', '', $totalStatsRaw[2]),
        ];

        // Test if data is valid.
        if ($totalStats['cases'] < $totalStats['recovered'] || $totalStats['cases'] < $totalStats['deaths']) {
            throw new \LogicException('Invalid statistical data detected for current cases.');
        }

        $countryInfo = (new ISO3166())->alpha2($this->countryCode);

        $data = [
            'meta' => [
                'country_code' => $this->countryCode,
                'country_name' => $countryInfo['name'],
                'timestamp' => time(),
            ],
            'total' => $totalStats
        ];

        return $data;
    }
}
