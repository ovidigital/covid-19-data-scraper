<?php

namespace OviDigital\Covid19DataScraper\Parser;

use OviDigital\Covid19DataScraper\Data\CountryData;
use OviDigital\Covid19DataScraper\Data\CountryDataInterface;
use OviDigital\Covid19DataScraper\Data\DataInterface;
use League\ISO3166\ISO3166;
use OviDigital\JsObjectToJson\JsConverter;
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
     * Extracts data from the content.
     *
     * @param string $content
     * @return DataInterface
     */
    public function parse(string $content): DataInterface
    {
        $countryInfo = (new ISO3166())->alpha2($this->countryCode);

        $meta = [
            'country_code' => $this->countryCode,
            'country_name' => $countryInfo['name'],
        ];

        $this->dataObject->addMeta($meta);

        $crawler = new Crawler($content);

        try {
            $this->parseTotals($crawler);
        } catch (\Exception $exception) {
            $this->dataObject->addError($exception->getMessage());
        }

        try {
            $this->parseDaily($crawler);
        } catch (\Exception $exception) {
            $this->dataObject->addError($exception->getMessage());
        }

        return $this->dataObject;
    }

    /**
     * Parse the totals.
     *
     * @param Crawler $crawler
     * @throws ParseException
     */
    protected function parseTotals(Crawler $crawler): void
    {
        $totalStatsRaw = $crawler->filter('#maincounter-wrap .maincounter-number')->each(
            function (Crawler $node) {
                return $node->text();
            }
        );

        if (empty($totalStatsRaw) || count($totalStatsRaw) !== 3) {
            throw new ParseException('Could not parse data for totals');
        }


        $cases = $this->convertToNumericString($totalStatsRaw[0]);
        $deaths = $this->convertToNumericString($totalStatsRaw[1]);
        $recovered = $this->convertToNumericString($totalStatsRaw[2]);

        if (empty($recovered) && $recovered !== 0) {
            $recovered = null;
        }

        $this->dataObject->setTotals($cases, $deaths, $recovered);
    }

    /**
     * Parse the daily stats.
     *
     * @param Crawler $crawler
     */
    protected function parseDaily(Crawler $crawler): void
    {
        $dailyCharts = [
            'cases' => [
                '_contains_string' => "Highcharts.chart('graph-cases-daily'",
                'raw_content' => '',
            ],
            'deaths' => [
                '_contains_string' => "Highcharts.chart('graph-deaths-daily'",
                'raw_content' => '',
            ],
            'recovered' => [
                '_contains_string' => "Highcharts.chart('cases-cured-daily'",
                'raw_content' => '',
            ],
        ];

        $crawler->filter('script')->each(
            function (Crawler $node) use (&$dailyCharts) {
                $text = $node->text();

                if ($text) {
                    foreach ($dailyCharts as $key => &$item) {
                        if (strpos($text, $item['_contains_string']) !== FALSE) {
                            $item['raw_content'] = str_replace(["\n", "\r"], '', $text);
                        }
                    }
                }
            }
        );

        foreach ($dailyCharts as $key => $item) {
            $content = $item['raw_content'];
            $splitted = explode('{', $content);
            unset($splitted[0]);
            $content = '{' . implode('{', $splitted);
            $content = rtrim($content, ");\t\n\r\0\x0B");

            $jsonString = JsConverter::convertToJson($content);

            $chartOptions = json_decode($jsonString, true);

            if (!empty($chartOptions['xAxis']['categories'])) {
                $values = $chartOptions['series'][0]['data'];
                $data = [];

                foreach ($chartOptions['xAxis']['categories'] as $i => $day) {

                    try {
                        $day = (new \DateTime($day))->format('Y-m-d');
                    } catch (\Exception $exception) {}

                    $data[$day] = isset($values[$i]) ? $values[$i] : null;
                }

                $this->dataObject->setDailyStats($key, $data);
            }
        }
    }

    /**
     * Convert to numeric string.
     *
     * @param string $input
     * @return string
     */
    protected function convertToNumericString(string $input): string
    {
        return preg_replace('/\D/', '', $input);
    }
}
