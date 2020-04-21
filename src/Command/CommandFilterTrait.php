<?php

namespace OviDigital\Covid19DataScraper\Command;

trait CommandFilterTrait
{
    /**
     * @var array List of filters.
     */
    protected $filters = [];

    /**
     * Get filters.
     *
     * @return array
     */
    protected function getFilters()
    {
        return $this->filters;
    }

    /**
     * Add country filter.
     *
     * @param string $countryCode
     */
    protected function addCountryFilter(string $countryCode)
    {
        $this->addFilter('country', $countryCode);
    }

    /**
     * Add a filter.
     *
     * @param string $key
     * @param mixed $value
     */
    protected function addFilter(string $key, $value)
    {
        $this->filters[$key] = $value;
    }

    /**
     * Get the country filter.
     *
     * @return string
     */
    protected function getCountryFilter()
    {
        return isset($this->filters['country']) ? $this->filters['country'] : '';
    }
}
