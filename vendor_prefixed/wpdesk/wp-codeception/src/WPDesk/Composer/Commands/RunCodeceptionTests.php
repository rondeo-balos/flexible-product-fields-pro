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
class RunCodeceptionTests extends \FPFProVendor\WPDesk\Composer\Codeception\Commands\BaseCommand
{
    const SINGLE = 'single';
    const FAST = 'fast';
    const WOOCOMMERCE_VERSION = 'woo_version';
    /**
     * Configure command.
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('run-codeception-tests')->setDescription('Run codeception tests.')->setDefinition(array(new \FPFProVendor\Symfony\Component\Console\Input\InputArgument(self::SINGLE, \FPFProVendor\Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Name of Single test to run.', 'all'), new \FPFProVendor\Symfony\Component\Console\Input\InputArgument(self::FAST, \FPFProVendor\Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Fast tests - do not shutdown docker-compose.', 'slow'), new \FPFProVendor\Symfony\Component\Console\Input\InputArgument(self::WOOCOMMERCE_VERSION, \FPFProVendor\Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'WooCommerce version to install.', '')));
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
        $dockerComposeYaml = 'vendor/wpdesk/wp-codeception/docker/docker-compose.yaml';
        $singleTest = $input->getArgument(self::SINGLE);
        $fastTest = $input->getArgument(self::FAST);
        $wooVersion = $input->getArgument(self::WOOCOMMERCE_VERSION);
        $cache_dir = \sys_get_temp_dir() . '/codeception_cache';
        if (!\file_exists($cache_dir)) {
            \mkdir($cache_dir, 0777, \true);
        }
        \putenv('TMP_CACHE_DIR=' . $cache_dir);
        $codecept_param = ' --html --verbose -f ';
        $additionalParameters = ' -e CODECEPT_PARAM="' . $codecept_param . '" ';
        if (!empty($singleTest) && 'all' !== $singleTest) {
            $additionalParameters .= ' -e CODECEPT_PARAM="' . $codecept_param . ' acceptance ' . $singleTest . '" ';
        }
        if (!empty($wooVersion)) {
            $additionalParameters .= ' -e WOOCOMMERCE_VERSION="' . $wooVersion . '" ';
        }
        $runTestsCommand = 'docker-compose -f ' . $dockerComposeYaml . ' run ' . $additionalParameters . 'codecept';
        $output->writeln('Codeception command: ' . $runTestsCommand);
        $this->execAndOutput($runTestsCommand, $output);
        if (empty($fastTest) || self::FAST !== $fastTest) {
            $this->execAndOutput('docker-compose -f ' . $dockerComposeYaml . ' down -v', $output);
        }
    }
}
