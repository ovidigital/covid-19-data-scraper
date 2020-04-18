<?php

namespace App\Util;

use Exception;
use League\ISO3166\ISO3166;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

class CommandUtil
{
    /**
     * Add alpha-2 country code option.
     *
     * @param Command $command
     */
    public static function addCountryCodeOption(Command $command)
    {
        $command->addOption(
            'country',
            'c',
            InputOption::VALUE_REQUIRED,
            'Limit command execution to a specific alpha-2 country code (e.g. "RO" for Romania, "AT" for Austria, "US" for United States of America etc.)'
        );
    }

    /**
     * Validates the alpha-2 country code option.
     *
     * @param InputInterface $input
     * @return string
     */
    public static function validateCountryCodeOption(InputInterface $input)
    {
        $countryCode = $input->getOption('country');

        if (!empty($countryCode)) {
            try {
                $info = (new ISO3166())->alpha2($countryCode);
            } catch (Exception $exception) {
                throw new InvalidOptionException('Invalid country code specified. ' . $exception->getMessage());
            }

            return strtoupper($countryCode);
        }

        return '';
    }
}
