<?php

namespace App\Scraper;

use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

abstract class HttpScraper implements ScraperInterface
{
    /**
     * @var string The url to scrape.
     */
    protected $url = '';

    /**
     * @var string The HTTP method used to scrape.
     */
    protected $method = 'GET';

    /**
     * @var array The HTTP client options.
     */
    protected $clientOptions = [];

    /**
     * @var string The scraped content.
     */
    protected $content = '';

    /**
     * Scrapes the content.
     *
     * @return void
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function scrape()
    {
        $client = new CurlHttpClient();

        $response = $client->request($this->method, $this->url, $this->clientOptions);

        $this->content = $response->getContent();
    }

    /**
     * Get the content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the data.
     *
     * @return array
     */
    abstract public function getData();
}
