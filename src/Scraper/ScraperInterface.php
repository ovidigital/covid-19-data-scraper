<?php

namespace App\Scraper;

interface ScraperInterface
{
    /**
     * Scrapes the information.
     *
     * @return void
     */
    public function scrape();

    /**
     * Gets the scraped content.
     *
     * @return string
     */
    public function getContent();

    /**
     * Retrieves the scraped data.
     *
     * @return array
     */
    public function getData();
}
