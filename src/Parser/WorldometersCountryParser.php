<?php

namespace OviDigital\Covid19DataScraper\Parser;

use OviDigital\Covid19DataScraper\Data\CountryData;
use OviDigital\Covid19DataScraper\Data\CountryDataInterface;
use OviDigital\Covid19DataScraper\Data\DataInterface;
use League\ISO3166\ISO3166;
use Symfony\Component\CssSelector\Exception\ParseException;
use Symfony\Component\DomCrawler\Crawler;

class WorldometersCountryParser implements ParserInterface
{
    /** @var string The country code */
    protected $countryCode;
    /** @var CountryData The data object */
    protected $dataObject;

    /**
     * WorldometersCountryParser constructor.
     *
     * @param string $countryCode The country code
     * @param CountryDataInterface|null $dataObject The data object
     */
    public function __construct(string $countryCode, CountryDataInterface $dataObject = null)
    {
        $this->countryCode = $countryCode;
        $this->dataObject = $dataObject ?: new CountryData();
    }

    /**
     * @param string $content
     * @return DataInterface
     * @throws ParseException
     */
    public function parse(string $content): DataInterface
    {
        $crawler = new Crawler($content);

        $totalStatsRaw = $crawler->filter('#maincounter-wrap .maincounter-number')->each(
            function (Crawler $node) {
                return $node->text();
            }
        );

        if (empty($totalStatsRaw) || count($totalStatsRaw) !== 3) {
            throw new ParseException('Cannot parse data');
        }

        $convertToNumeric = function (string $input) {
            return preg_replace('/\D/', '', $input);
        };

        $cases = $convertToNumeric($totalStatsRaw[0]);
        $deaths = $convertToNumeric($totalStatsRaw[1]);
        $recovered = $convertToNumeric($totalStatsRaw[2]);

        if (empty($recovered) && $recovered !== 0) {
            $recovered = null;
        }

        $this->dataObject->setTotals($cases, $deaths, $recovered);

        $countryInfo = (new ISO3166())->alpha2($this->countryCode);

        $meta = [
            'country_code' => $this->countryCode,
            'country_name' => $countryInfo['name'],
        ];

        $this->dataObject->addMeta($meta);

        return $this->dataObject;
    }
}
