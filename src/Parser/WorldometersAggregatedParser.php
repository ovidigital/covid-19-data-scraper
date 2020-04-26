<?php

namespace OviDigital\Covid19DataScraper\Parser;

use League\ISO3166\ISO3166;
use OviDigital\Covid19DataScraper\Data\AggregatedCountryData;
use OviDigital\Covid19DataScraper\Data\DataInterface;
use OviDigital\Covid19DataScraper\Util\WorldometersUtil;
use Symfony\Component\DomCrawler\Crawler;

class WorldometersAggregatedParser implements ParserInterface
{

    /** @var DataInterface The data object */
    protected $dataObject;

    /** @var array List of country codes */
    protected $countryCodes;

    /**
     * WorldometersCountryParser constructor.
     *
     * @param array $countryCodes
     * @param DataInterface|null $dataObject The data object
     */
    public function __construct(array $countryCodes = [], DataInterface $dataObject = null)
    {
        $this->countryCodes = $countryCodes;
        $this->dataObject = $dataObject ?: new AggregatedCountryData();
    }

    /**
     * Extracts data from the content.
     *
     * @param string $content
     * @return DataInterface
     */
    public function parse(string $content): DataInterface
    {
        $crawler = new Crawler($content);

        $this->parseTableToday($crawler);

        return $this->dataObject;
    }

    /**
     * Parse the table with data for today.
     *
     * @param Crawler $crawler
     */
    protected function parseTableToday(Crawler $crawler): void
    {
        $tableToday = $crawler->filter('#main_table_countries_today');

        $tableHeaders = $tableToday->filter('thead th')->extract(['_text']);

        $tableHeaders = preg_replace('@[^a-z0-9]@i', '', $tableHeaders);

        if (empty($tableHeaders)) {
            return;
        }

        $selectedCols = [
            [
                'key' => 'country_slug',
                'pattern' => '/country/i',
            ],
            [
                'key' => 'total_cases',
                'pattern' => '/total.*?cases/i',
            ],
            [
                'key' => 'new_cases_today',
                'pattern' => '/new.*?cases/i',
            ],
            [
                'key' => 'total_deaths',
                'pattern' => '/total.*?deaths/i',
            ],
            [
                'key' => 'new_deaths_today',
                'pattern' => '/new.*?deaths/i',
            ],
            [
                'key' => 'total_recovered',
                'pattern' => '/total.*?recovered/i',
            ],
            [
                'key' => 'total_active_cases',
                'pattern' => '/active.*?cases/i',
            ],
            [
                'key' => 'total_serious_critical',
                'pattern' => '/(serious|critical)/i',
            ],
            [
                'key' => 'total_tests',
                'pattern' => '/total.*?tests/i',
            ],
            [
                'key' => 'cases_per_million',
                'pattern' => '/cases.*?1m/i',
            ],
            [
                'key' => 'deaths_per_million',
                'pattern' => '/deaths.*?1m/i',
            ],
            [
                'key' => 'tests_per_million',
                'pattern' => '/tests.*?1m/i',
            ],
        ];

        foreach ($tableHeaders as $index => $header) {
            foreach ($selectedCols as &$col) {
                if (isset($col['index'])) {
                    continue;
                }
                if (preg_match($col['pattern'], $header)) {
                    $col['index'] = $index;
                }
            }
            // Destroy the reference variable
            unset($col);
        }

        $dataColumns = [];

        foreach ($selectedCols as $col) {
            if (isset($col['index'])) {
                $dataColumns[$col['index']] = $col['key'];
            }
        }

        $tableRows = $tableToday->filter('tbody tr:not(.total_row_world)')->each(
            function (Crawler $node) {
                return $node->filter('td')->each(
                    function (Crawler $tdNode, $i) {
                        if ($i === 0) {
                            $link = $tdNode->filter('a.mt_a');
                            if ($link->matches('a.mt_a')) {
                                $href = $link->attr('href');
                                if (preg_match('@country/(.*?)/?$@ui', $href, $matches)) {
                                    return $matches[1];
                                }
                            }
                            return '';
                        } else {
                            $value = preg_replace('@[^0-9.-]@ui', '', $tdNode->text(''));
                            return $value === "" ? null : 0 + $value;
                        }
                    }
                );
            }
        );

        $data = [];
        $countrySlugsWithCountryCodes = WorldometersUtil::getCountrySlugs();

        foreach ($tableRows as $row) {
            $dataRow = [];

            foreach ($dataColumns as $index => $columnKey) {
                $dataRow[$columnKey] = isset($row[$index]) ? $row[$index] : null;
            }

            $countrySlug = !empty($dataRow['country_slug']) ? $dataRow['country_slug'] : '';

            if ($countrySlug && $countryCode = array_search($countrySlug, $countrySlugsWithCountryCodes)) {
                if (!empty($this->countryCodes)) {
                    if (!in_array($countryCode, $this->countryCodes)) {
                        continue;
                    }
                }
                $countryInfo = (new ISO3166())->alpha2($countryCode);
                unset($dataRow['country_slug']);

                $data[$countryCode] = [
                    'meta' => [
                        'country_code' => $countryCode,
                        'country_name' => $countryInfo['name'],
                        'country_slug' => $countrySlug,
                    ],
                    'data' => $dataRow
                ];
            }
        }

        $this->dataObject->setData($data);
    }
}
