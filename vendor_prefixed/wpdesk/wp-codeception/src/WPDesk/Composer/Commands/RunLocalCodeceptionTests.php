<?php

namespace FPFProVendor\WPDesk\Composer\Codeception\Commands;

use FPFProVendor\Symfony\Component\Console\Input\InputArgument;
use FPFProVendor\Symfony\Component\Console\Input\InputInterface;
use FPFProVendor\Symfony\Component\Console\Output\OutputInterface;
/**
 * Codeception tests run command.
 *
 * @package WPDesk\Composer\Codeception\Commands
 */
class RunLocalCodeceptionTests extends \FPFProVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests
{
    /**
     * Configure command.
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('run-local-codeception-tests')->setDescription('Run local codeception tests.')->setDefinition(array(new \FPFProVendor\Symfony\Component\Console\Input\InputArgument(self::SINGLE, \FPFProVendor\Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Name of Single test to run.', ' '), new \FPFProVendor\Symfony\Component\Console\Input\InputArgument(self::WOOCOMMERCE_VERSION, \FPFProVendor\Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'WooCommerce version to install.', '')));
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
        $singleTest = $input->getArgument(self::SINGLE);
        $wooVersion = $input->getArgument(self::WOOCOMMERCE_VERSION);
        $runLocalTests = 'sh ./vendor/wpdesk/wp-codeception/scripts/run_local_tests.sh ' . $singleTest . ' ' . $wooVersion;
        $this->execAndOutput($runLocalTests, $output);
    }
}
