<?php

namespace OviDigital\Covid19DataScraper\Data;

interface CountryDataInterface extends DataInterface {
    /**
     * Set totals.
     *
     * @param int $cases The total number of confirmed cases
     * @param int $deaths The total number of deaths
     * @param int|null $recovered The total number of recovered patients
     */
    public function setTotals(int $cases, int $deaths, int $recovered = null): void;

    /**
     * Get totals.
     *
     * @return array Total cases, deaths and recovered
     */
    public function getTotals(): array;

    /**
     * Get meta data.
     *
     * @return array
     */
    public function getMeta(): array;

    /**
     * Get total cases.
     *
     * @return int The total number of confirmed cases
     */
    public function getTotalCases(): int;

    /**
     * Get total deaths.
     *
     * @return int The total number of deaths
     */
    public function getTotalDeaths(): int;

    /**
     * Get total recovered patients.
     *
     * Such data is not always available, in which case the returned value will be NULL.
     *
     * @return int|null The total number of recovered patients
     */
    public function getTotalRecovered(): ?int;


}
