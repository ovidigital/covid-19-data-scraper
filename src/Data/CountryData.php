<?php

namespace OviDigital\Covid19DataScraper\Data;

class CountryData extends BaseData implements CountryDataInterface
{
    /**
     * @inheritDoc
     */
    public function setTotals(int $cases, int $deaths, int $recovered = null): void
    {
        // Test if data is valid.
        if ($cases < $deaths) {
            $this->addError('Invalid data: Total cases lower than total deaths.');
        }
        if ($recovered && $cases < $recovered) {
            $this->addError('Invalid data: Total cases lower than total recovered.');
        }

        $this->setData(
            [
                'cases' => $cases,
                'deaths' => $deaths,
                'recovered' => $recovered,
            ],
            'totals'
        );
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
    public function getTotals(): array
    {
        return $this->getData('totals');
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
        $dailyData = $this->getData('daily');
        $dailyData[$key] = $data;
        $this->setData($dailyData, 'daily');
    }

    /**
     * @inheritDoc
     */
    public function getDailyStats(): array
    {
        return $this->getData('daily');
    }

    /**
     * Initialize data.
     */
    protected function init(): void
    {
        parent::init();

        $this->setData(
            [
                'totals' => [
                    'cases' => '',
                    'deaths' => '',
                    'recovered' => '',
                ],
                'daily' => [
                    'new_cases' => [],
                    'new_deaths' => [],
                    'new_recovered' => [],
                    'total_active_cases' => [],
                    'total_deaths' => [],
                ],
            ]
        );
    }
}
