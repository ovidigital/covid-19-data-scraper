<?php

namespace OviDigital\Covid19DataScraper\Data;

interface DataInterface
{
    /**
     * Export as array.
     *
     * @return array The stored data
     */
    public function toArray(): array;

    /**
     * Export as JSON.
     *
     * @return string The stored data as JSON
     */
    public function toJson(): string;

    /**
     * Export as CSV.
     *
     * @return string The stored data as CSV
     */
    public function toCsv(): string;

    /**
     * Get the data.
     *
     * @param string $key Specific key to get partial data for
     * @return mixed
     */
    public function getData(string $key = '');

    /**
     * Set the data.
     * @param array $data
     * @param string $key Specific key to set data for
     */
    public function setData(array $data, string $key = ''): void;

    /**
     * Add an error.
     *
     * @param string $message The error message
     */
    public function addError(string $message): void;

    /**
     * Get the errors.
     *
     * @return array The errors.
     */
    public function getErrors(): array;

    /**
     * Get the meta data.
     *
     * @return array
     */
    public function getMeta(): array;

    /**
     * Add meta data.
     *
     * @param array $meta
     */
    public function addMeta(array $meta): void;
}
