<?php

namespace App\Scraper;

use App\Data\DataInterface;

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
