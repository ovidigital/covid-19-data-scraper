# COVID-19 Data Scraper
###### PHP CLI utility to extract COVID-19 statistical data from multiple sources

## Context
[COVID-19](https://en.wikipedia.org/wiki/Coronavirus_disease_2019) (Coronavirus disease 2019) is an infectious disease caused by severe acute respiratory syndrome coronavirus 2 (SARS-CoV-2).
The disease was first identified in December 2019 in Wuhan, the capital of China's Hubei province, and has since spread globally, resulting in the ongoing 2019–2020 coronavirus pandemic.

This utility aims to be a quick and efficient way to extract COVID-19 statistical data from multiple sources on the Internet and provide this data in multiple formats (e.g. CSV, JSON, XML etc.)

## Disclaimer
This software is provided for educational and demonstration purposes only.

By using this software, you might access resources for which you need prior permission from their respective owners (e.g. [Worldometers Coronavirus](https://www.worldometers.info/coronavirus/)).

It is the sole responsibility of the user of this software to ensure proper permission is granted before using this software to access such resources.

## License
The software is licensed under the MIT license, please check [LICENSE.md](LICENSE.md) for more information.

## Installation
This PHP CLI utility is built on top of [Symfony Console Component](https://symfony.com/doc/current/components/console.html) and it uses [composer](https://getcomposer.org/) for dependency management.

1. Download or clone this repository to your local environment
2. Open a command line interface inside the downloaded or cloned folder
3. Run `composer install`

## Usage

The entry point to the console app is `./covid`
```bash
# List commands
./covid list

# Example 1: Query statistical data for Romania using Worldometers
./covid query:wm --country RO
```
