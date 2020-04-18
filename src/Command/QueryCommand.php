<?php

namespace App\Command;

use App\Util\CommandUtil;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueryCommand extends Command
{
    use CommandFilterTrait;

    protected $description = '';
    protected $helpText = '';
    protected $filters = [];

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setDescription($this->description)
            ->setHelp($this->helpText);

        // Add country code option.
        CommandUtil::addCountryCodeOption($this);
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $countryCode = CommandUtil::validateCountryCodeOption($input);

        if ($countryCode) {
            $this->addCountryFilter($countryCode);
        }
    }
}
