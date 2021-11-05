<?php

namespace FPFProVendor\WPDesk\Composer\Codeception\Commands;

use FPFProVendor\Symfony\Component\Console\Input\InputArgument;
use FPFProVendor\Symfony\Component\Console\Input\InputInterface;
use FPFProVendor\Symfony\Component\Console\Output\OutputInterface;
use FPFProVendor\Symfony\Component\Yaml\Exception\ParseException;
use FPFProVendor\Symfony\Component\Yaml\Yaml;
/**
 * Codeception tests run command.
 *
 * @package WPDesk\Composer\Codeception\Commands
 */
class RunLocalCodeceptionTests extends \FPFProVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests
{
    use LocalCodeceptionTrait;
    /**
     * Configure command.
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('run-local-codeception-tests')->setDescription('Run local codeception tests.')->setDefinition(array(new \FPFProVendor\Symfony\Component\Console\Input\InputArgument(self::SINGLE, \FPFProVendor\Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Name of Single test to run.', ' ')));
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
        $this->prepareWpConfig($output, $configuration);
        $singleTest = $input->getArgument(self::SINGLE);
        $sep = \DIRECTORY_SEPARATOR;
        $codecept = "vendor{$sep}bin{$sep}codecept";
        $cleanOutput = $codecept . ' clean';
        $this->execAndOutput($cleanOutput, $output);
        $runLocalTests = $codecept . ' run -f --steps --html --verbose acceptance ' . $singleTest;
        $this->execAndOutput($runLocalTests, $output);
    }
}
