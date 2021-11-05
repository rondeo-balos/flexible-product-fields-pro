<?php

namespace FPFProVendor\WPDesk\Codeception\Command;

use FPFProVendor\Codeception\Command\GenerateTest;
use FPFProVendor\Codeception\CustomCommandInterface;
use FPFProVendor\Symfony\Component\Console\Input\InputInterface;
use FPFProVendor\Symfony\Component\Console\Output\OutputInterface;
/**
 * Generates codeception example test for WP Desk plugin activation.
 *
 * @package WPDesk\Codeception\Command
 */
class GeneratePluginActivation extends \FPFProVendor\Codeception\Command\GenerateTest implements \FPFProVendor\Codeception\CustomCommandInterface
{
    /**
     * Get codeception command description.
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Generates plugin activation tests.';
    }
    /**
     * Returns the name of the command.
     *
     * @return string
     */
    public static function getCommandName()
    {
        return 'generate:activation';
    }
    /**
     * Get generator class.
     *
     * @param array  $config .
     * @param string $class .
     * @return AcceptanceTestGenerator
     */
    protected function getGenerator($config, $class)
    {
        return new \FPFProVendor\WPDesk\Codeception\Command\AcceptanceTestGenerator($config, $class);
    }
    /**
     * Execute command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function execute(\FPFProVendor\Symfony\Component\Console\Input\InputInterface $input, \FPFProVendor\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $suite = $input->getArgument('suite');
        $class = $input->getArgument('class');
        $config = $this->getSuiteConfig($suite);
        $className = $this->getShortClassName($class);
        $path = $this->createDirectoryFor($config['path'], $class);
        $filename = $this->completeSuffix($className, 'Cest');
        $filename = $path . $filename;
        $gen = $this->getGenerator($config, $class);
        $res = $this->createFile($filename, $gen->produce());
        if (!$res) {
            $output->writeln("<error>Test {$filename} already exists</error>");
            return;
        }
        $output->writeln("<info>Test was created in {$filename}</info>");
    }
}
