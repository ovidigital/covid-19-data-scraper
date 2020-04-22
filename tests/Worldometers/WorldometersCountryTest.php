<?php

namespace OviDigital\Tests\Worldometers;

use OviDigital\Covid19DataScraper\Data\CountryDataInterface;
use OviDigital\Covid19DataScraper\Parser\WorldometersCountryParser;
use OviDigital\Covid19DataScraper\Scraper\WorldometersCountryScraper;
use PHPUnit\Framework\TestCase;

class WorldometersCountryTest extends TestCase {

    public function testInvalidCountryCode()
    {
        $this->expectException(\InvalidArgumentException::class);

        new WorldometersCountryScraper('ZZ');
    }

    public function testParsedData()
    {
        $countryCode = 'RO';
        $countryName = 'Romania';

        $parser = new WorldometersCountryParser($countryCode);

        $content = file_get_contents(__DIR__ . '/worldometers_country_sample.html');

        $dataObject = $parser->parse($content);

        $this->assertInstanceOf(CountryDataInterface::class, $dataObject);

        $dataAsArray = $dataObject->getData();

        $this->assertIsArray($dataAsArray);

        $this->assertEquals($countryCode, $dataAsArray['meta']['country_code']);
        $this->assertEquals($countryName, $dataAsArray['meta']['country_name']);

        $expectedTotals = [
            'cases' => 1500,
            'deaths' => 60,
            'recovered' => 120
        ];

        $this->assertEquals($expectedTotals, $dataAsArray['totals']);

        $dailyStats = $dataAsArray['daily'];

        $this->assertEquals(7, count($dailyStats['new_cases']));
        $this->assertEquals(7, count($dailyStats['new_deaths']));
        $this->assertEquals(7, count($dailyStats['new_recovered']));
        $this->assertEquals(7, count($dailyStats['total_active_cases']));
        $this->assertEquals(7, count($dailyStats['total_deaths']));

        $this->assertEquals('null', $dailyStats['new_cases']['2020-02-15']);
        $this->assertEquals(200, $dailyStats['new_cases']['2020-02-18']);

        $this->assertEquals(0, $dailyStats['new_deaths']['2020-02-15']);
        $this->assertEquals(20, $dailyStats['new_deaths']['2020-02-20']);

        $this->assertEquals(0, $dailyStats['new_recovered']['2020-02-15']);
        $this->assertEquals(40, $dailyStats['new_recovered']['2020-02-20']);

        $this->assertEquals('null', $dailyStats['total_active_cases']['2020-02-15']);
        $this->assertEquals(910, $dailyStats['total_active_cases']['2020-02-20']);

        $this->assertEquals(0, $dailyStats['total_deaths']['2020-02-15']);
        $this->assertEquals(30, $dailyStats['total_deaths']['2020-02-20']);
    }

}
