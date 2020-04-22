<?php

namespace OviDigital\Covid19DataScraper\Data;

class CountryData implements CountryDataInterface
{
    /** @var array Stores all data */
    protected $data = [];

    /**
     * CountryData constructor.
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
        $this->data = [
            'meta' => [
                'timestamp' => time(),
            ],
            'totals' => [
                'cases' => '',
                'deaths' => '',
                'recovered' => '',
            ],
            'daily' => [
                'cases' => [],
                'deaths' => [],
                'recovered' => [],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function getDataAsJson(): string
    {
        $output = json_encode($this->getData(), JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT|JSON_PARTIAL_OUTPUT_ON_ERROR);

        return $output ?: '""';
    }

    /**
     * @inheritDoc
     *
     * @todo: implement method
     */
    public function getDataAsCsv(): string
    {
        return 'Not implemented yet';
    }

    /**
     * @inheritDoc
     */
    public function getMeta(): array
    {
        return $this->data['meta'];
    }

    /**
     * @inheritDoc
     */
    public function setTotals(int $cases, int $deaths, int $recovered = null): void
    {
        // Test if data is valid.
        if ($cases < $deaths){
            $this->addError('Invalid data: Total cases lower than total deaths.');
        }
        if ($recovered && $cases < $recovered) {
            $this->addError('Invalid data: Total cases lower than total recovered.');
        }

        $this->data['totals'] = [
            'cases' => $cases,
            'deaths' => $deaths,
            'recovered' => $recovered,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTotals(): array
    {
        return $this->data['totals'];
    }

    /**
     * @inheritDoc
     */
    public function getTotalCases(): int
    {
        return $this->getTotals()['cases'];
    }

    /**
     * @inheritDoc
     */
    public function getTotalDeaths(): int
    {
        return $this->getTotals()['deaths'];
    }

    /**
     * @inheritDoc
     */
    public function getTotalRecovered(): ?int
    {
        return $this->getTotals()['recovered'];
    }

    /**
     * @inheritDoc
     */
    public function setDailyStats(string $key, array $data): void
    {
        $this->data['daily'][$key] = $data;
    }

    /**
     * @inheritDoc
     */
    public function getDailyStats(): array
    {
        return $this->data['daily'];
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return isset($this->data['errors']) ? $this->data['errors'] : [];
    }

    /**
     * @inheritDoc
     */
    public function addError(string $message): void
    {
        if (!isset($this->data['errors'])) {
            $this->data['errors'] = [];
        }

        $this->data['errors'][] = $message;
    }

    /**
     * @inheritDoc
     */
    public function addMeta(array $meta): void
    {
        $this->data['meta'] = array_merge($this->data['meta'], $meta);
    }
}
