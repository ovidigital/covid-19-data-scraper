<?php

namespace OviDigital\Covid19DataScraper\Data;

class BaseData implements DataInterface
{
    /** @var array Stores all data */
    protected $dataStore = [];

    /** @var string The key used for wrapping the data */
    protected $dataWrapperKey = 'data';

    /**
     * BaseData constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Initialize data.
     */
    protected function init(): void
    {
        $this->dataStore = [
            'meta' => [
                'timestamp' => time(),
            ],
        ];

        $this->setData([]);
    }

    /**
     * @inheritDoc
     */
    public function setData(array $data, string $key = ''): void
    {
        if ($key) {
            $this->dataStore[$this->dataWrapperKey][$key] = $data;
        } else {
            $this->dataStore[$this->dataWrapperKey] = $data;
        }
    }

    /**
     * @inheritDoc
     */
    public function getMeta(): array
    {
        return $this->dataStore['meta'];
    }

    /**
     * @inheritDoc
     */
    public function toJson(): string
    {
        $output = json_encode($this->toArray(), JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_PARTIAL_OUTPUT_ON_ERROR);

        return $output ?: '""';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->dataStore;
    }

    /**
     * @inheritDoc
     *
     * @todo: implement method
     */
    public function toCsv(): string
    {
        return 'Not implemented yet';
    }

    /**
     * @inheritDoc
     */
    public function getData(string $key = '')
    {
        return $key ? $this->dataStore[$this->dataWrapperKey][$key] : $this->dataStore[$this->dataWrapperKey];
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return isset($this->dataStore['errors']) ? $this->dataStore['errors'] : [];
    }

    /**
     * @inheritDoc
     */
    public function addError(string $message): void
    {
        if (!isset($this->dataStore['errors'])) {
            $this->dataStore['errors'] = [];
        }

        $this->dataStore['errors'][] = $message;
    }

    /**
     * @inheritDoc
     */
    public function addMeta(array $meta): void
    {
        $this->dataStore['meta'] = array_merge($this->dataStore['meta'], $meta);
    }
}
