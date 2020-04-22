# ovidigital/covid-19-data-scraper
###### PHP library to extract COVID-19 statistical data from multiple sources

[![Latest Version](https://img.shields.io/github/release/ovidigital/covid-19-data-scraper.svg?style=flat-square)](https://github.com/ovidigital/covid-19-data-scraper/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/ovidigital/covid-19-data-scraper/master.svg?style=flat-square&logo=travis&logoColor=white)](https://travis-ci.org/ovidigital/covid-19-data-scraper)

This library aims to be a quick way to extract statistical data for [COVID-19](https://en.wikipedia.org/wiki/Coronavirus_disease_2019) (Coronavirus disease 2019) from multiple sources on the Internet and provide this data in multiple formats (PHP Array, JSON, CSV etc.)

## Disclaimer
This software is provided for educational and demonstration purposes only.

By using this software, you might access resources for which you need prior permission from their respective owners (e.g. [Worldometers Coronavirus](https://www.worldometers.info/coronavirus/)).

It is the sole responsibility of the user of this software to ensure proper permission is granted before using this software to access such resources.

## License
This project is licensed under the terms of the MIT license.

Check the [LICENSE.md](LICENSE.md) file for license rights and limitations.

## Installation

```bash
composer require ovidigital/covid-19-data-scraper
```

## Usage


```php
use OviDigital\Covid19DataScraper\StatisticsService;

$statisticsService = new StatisticsService();

// Scrape statistics for Romania (alpha-2 country code "RO") from Worldometers
$dataObject = $statisticsService->getWorldometersCountry('RO');

// Get data as PHP array
$dataAsArray = $dataObject->getData();

// Get data in JSON format
$dataAsJson = $dataObject->getDataAsJson();
```

## Example of returned data
```
Array
(
    [meta] => Array
        (
            [timestamp] => 1587555393
            [country_code] => RO
            [country_name] => Romania
        )

    [totals] => Array
        (
            [cases] => 1500
            [deaths] => 60
            [recovered] => 120
        )

    [daily] => Array
        (
            [cases] => Array
                (
                    [2020-02-15] => null
                    [2020-02-16] => null
                    [2020-02-17] => 100
                    [2020-02-18] => 200
                    [2020-02-19] => 300
                    [2020-02-20] => 400
                    [2020-02-21] => 500
                )

            [deaths] => Array
                (
                    [2020-02-15] => 0
                    [2020-02-16] => 0
                    [2020-02-17] => 0
                    [2020-02-18] => 0
                    [2020-02-19] => 10
                    [2020-02-20] => 20
                    [2020-02-21] => 30
                )

            [recovered] => Array
                (
                    [2020-02-15] => 0
                    [2020-02-16] => 0
                    [2020-02-17] => 0
                    [2020-02-18] => 0
                    [2020-02-19] => 20
                    [2020-02-20] => 40
                    [2020-02-21] => 60
                )

        )

)
```
## Contributing

Feel free to submit a pull request or create an issue.
