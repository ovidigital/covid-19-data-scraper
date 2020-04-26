# ovidigital/covid-19-data-scraper
###### PHP library to extract COVID-19 statistical data from multiple sources

[![Latest Version](https://img.shields.io/packagist/v/ovidigital/covid-19-data-scraper.svg?style=flat-square&cacheSeconds=3600&label=latest%20version)](https://github.com/ovidigital/covid-19-data-scraper/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/ovidigital/covid-19-data-scraper/master.svg?style=flat-square&logo=travis&logoColor=white)](https://travis-ci.com/ovidigital/covid-19-data-scraper)

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
$dataAsArray = $dataObject->toArray();

// Get data in JSON format
$dataAsJson = $dataObject->toJson();
```

## Example of returned data
```json
{
    "meta": {
        "timestamp": 1587901089,
        "country_code": "RO",
        "country_name": "Romania"
    },
    "data": {
        "totals": {
            "cases": 1500,
            "deaths": 60,
            "recovered": 120
        },
        "daily": {
            "new_cases": {
                "2020-02-15": "null",
                "2020-02-16": "null",
                "2020-02-17": 100,
                "2020-02-18": 200,
                "2020-02-19": 300,
                "2020-02-20": 400,
                "2020-02-21": 500
            },
            "new_deaths": {
                "2020-02-15": 0,
                "2020-02-16": 0,
                "2020-02-17": 0,
                "2020-02-18": 0,
                "2020-02-19": 10,
                "2020-02-20": 20,
                "2020-02-21": 30
            },
            "new_recovered": {
                "2020-02-15": 0,
                "2020-02-16": 0,
                "2020-02-17": 0,
                "2020-02-18": 0,
                "2020-02-19": 20,
                "2020-02-20": 40,
                "2020-02-21": 60
            },
            "total_active_cases": {
                "2020-02-15": "null",
                "2020-02-16": "null",
                "2020-02-17": 100,
                "2020-02-18": 300,
                "2020-02-19": 570,
                "2020-02-20": 910,
                "2020-02-21": 1320
            },
            "total_deaths": {
                "2020-02-15": 0,
                "2020-02-16": 0,
                "2020-02-17": 0,
                "2020-02-18": 0,
                "2020-02-19": 10,
                "2020-02-20": 30,
                "2020-02-21": 60
            }
        }
    }
}
```
## Contributing

Feel free to submit a pull request or create an issue.
