<?php

namespace OviDigital\Covid19DataScraper\Scraper;

use OviDigital\Covid19DataScraper\Data\DataInterface;

interface ScraperInterface
{
    /**
     * Scrapes the information.
     *
     * @return void
     */
    public function scrape(): void;

    /**
     * Gets the scraped content.
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Retrieves the scraped data.
     *
     * @return DataInterface
     */
    public function getDataObject(): DataInterface;
}
