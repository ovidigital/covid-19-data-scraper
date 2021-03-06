<?php

namespace OviDigital\Covid19DataScraper;

use OviDigital\Covid19DataScraper\Scraper\WorldometersCountryScraper;
use OviDigital\Covid19DataScraper\Scraper\WorldometersAggregatedScraper;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class StatisticsService
{
    /**
     * Get Worldometers statistics.
     *
     * @param array $countryCodes
     * @return Data\DataInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getWorldometersAggregated(array $countryCodes = [])
    {
        $scraper = new WorldometersAggregatedScraper($countryCodes);
        $scraper->scrape();
        return $scraper->getDataObject();
    }

    /**
     * Get Worldometers statistics for a specific country.
     *
     * @param string $countryCode
     * @return Data\DataInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getWorldometersCountry(string $countryCode)
    {
        $scraper = new WorldometersCountryScraper($countryCode);
        $scraper->scrape();
        return $scraper->getDataObject();
    }
}
