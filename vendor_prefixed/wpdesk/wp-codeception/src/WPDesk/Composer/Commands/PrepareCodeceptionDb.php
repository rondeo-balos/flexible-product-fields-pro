<?php

namespace FPFProVendor\WPDesk\Composer\Codeception\Commands;

use FPFProVendor\Symfony\Component\Console\Input\InputArgument;
use FPFProVendor\Symfony\Component\Console\Input\InputInterface;
use FPFProVendor\Symfony\Component\Console\Output\OutputInterface;
use FPFProVendor\Symfony\Component\Yaml\Exception\ParseException;
use FPFProVendor\Symfony\Component\Yaml\Yaml;
/**
 * Prepare Database for Codeception tests command.
 *
 * @package WPDesk\Composer\Codeception\Commands
 */
class PrepareCodeceptionDb extends \FPFProVendor\WPDesk\Composer\Codeception\Commands\BaseCommand
{
    use LocalCodeceptionTrait;
    /**
     * Configure command.
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('prepare-codeception-db')->setDescription('Prepare codeception database.');
    }
    /**
     * Execute command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(\FPFProVendor\Symfony\Component\Console\Input\InputInterface $input, \FPFProVendor\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $configuration = $this->getWpDeskConfiguration();
        $this->installPlugin($configuration->getPluginDir(), $output, $configuration);
        $this->prepareCommonWpWcConfiguration($configuration, $output);
        $this->prepareWpConfig($output, $configuration);
        $this->executeWpCliAndOutput('plugin activate ' . $configuration->getPluginSlug(), $output, $configuration->getApacheDocumentRoot());
        $this->activatePlugins($output, $configuration);
        $this->executeWpCliAndOutput('db export ' . \getcwd() . '/tests/codeception/tests/_data/db.sql', $output, $configuration->getApacheDocumentRoot());
    }
}
