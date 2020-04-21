<?php

namespace OviDigital\Covid19DataScraper\Data;

interface DataInterface {
    /**
     * Get the data as array.
     *
     * @return array The stored data
     */
    public function getData(): array;

    /**
     * Get the data as JSON.
     *
     * @return string The stored data as JSON
     */
    public function getDataAsJson(): string;

    /**
     * Get the data as CSV.
     *
     * @return string The stored data as CSV
     */
    public function getDataAsCsv(): string;

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
     * Add meta data.
     *
     * @param array $meta
     */
    public function addMeta(array $meta): void;
}
