<?php

namespace OviDigital\Tests\Worldometers;

use OviDigital\Covid19DataScraper\Data\DataInterface;
use OviDigital\Covid19DataScraper\Parser\WorldometersAggregatedParser;
use OviDigital\Covid19DataScraper\Scraper\WorldometersAggregatedScraper;
use PHPUnit\Framework\TestCase;

class WorldometersAggregatedTest extends TestCase
{
    protected $content;

    public function testParsedData()
    {
        $parser = new WorldometersAggregatedParser();

        $scraper = new WorldometersAggregatedScraper([], $parser);

        $reflection = new \ReflectionClass($scraper);
        $content = $reflection->getProperty('content');
        $content->setAccessible(true);
        $content->setValue($scraper, $this->content);

        $dataObject = $scraper->getDataObject();

        $this->assertInstanceOf(DataInterface::class, $dataObject);

        $dataAsArray = $dataObject->toArray();

        $this->assertIsArray($dataAsArray);

        $data = $dataAsArray['countries'];

        $this->assertCount(2, $data);

        $usaData = $data['US']['data'];

        $this->assertCount(11, $usaData);

        $this->assertEquals(123456, $usaData['total_cases']);
        $this->assertEquals(1337, $usaData['new_cases_today']);
        $this->assertEquals(45678, $usaData['total_deaths']);
        $this->assertEquals(101, $usaData['new_deaths_today']);
        $this->assertEquals(80000, $usaData['total_recovered']);
        $this->assertEquals(765432, $usaData['total_active_cases']);
        $this->assertEquals(13337, $usaData['total_serious_critical']);
        $this->assertEquals(4194304, $usaData['total_tests']);
        $this->assertEquals(2121, $usaData['cases_per_million']);
        $this->assertEquals(196, $usaData['deaths_per_million']);
        $this->assertEquals(16384, $usaData['tests_per_million']);

        $meta = $dataObject->getMeta();

        $this->assertArrayHasKey('timestamp', $meta);

        $this->assertEmpty($dataObject->getErrors());

        $dataObject->addError('Just a test error');

        $this->assertContainsEquals('Just a test error', $dataObject->getErrors());
    }

    public function testParsedDataWithCountryFilter()
    {
        $parser = new WorldometersAggregatedParser(['RO']);

        $dataObject = $parser->parse($this->content);

        $this->assertInstanceOf(DataInterface::class, $dataObject);

        $dataAsArray = $dataObject->toArray();

        $this->assertIsArray($dataAsArray);

        $data = $dataAsArray['countries'];

        $this->assertCount(1, $data);

        $romaniaData = $data['RO']['data'];

        $this->assertEquals(10123, $romaniaData['total_cases']);
        $this->assertEquals(321, $romaniaData['new_cases_today']);
        $this->assertEquals(500, $romaniaData['total_deaths']);
        $this->assertEquals(-5, $romaniaData['new_deaths_today']);
        $this->assertEquals(2350, $romaniaData['total_recovered']);
        $this->assertEquals(7123, $romaniaData['total_active_cases']);
        $this->assertEquals(210, $romaniaData['total_serious_critical']);
        $this->assertEquals(112112, $romaniaData['total_tests']);
        $this->assertEquals(543, $romaniaData['cases_per_million']);
        $this->assertEquals(25.15, $romaniaData['deaths_per_million']);
        $this->assertEquals(12345, $romaniaData['tests_per_million']);

        $dataAsJson = $dataObject->toJson();
        $this->assertEquals($dataAsArray, json_decode($dataAsJson, true));

        $this->assertEquals('Not implemented yet', $dataObject->toCsv());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->content = file_get_contents(__DIR__ . '/worldometers_aggregated_sample.html');
    }
}
