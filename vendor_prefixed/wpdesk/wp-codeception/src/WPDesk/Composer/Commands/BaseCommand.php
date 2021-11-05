<?php

namespace FPFProVendor\WPDesk\Composer\Codeception\Commands;

use FPFProVendor\Composer\Command\BaseCommand as CodeceptionBaseCommand;
use FPFProVendor\Symfony\Component\Console\Output\OutputInterface;
/**
 * Base for commands - declares common methods.
 *
 * @package WPDesk\Composer\Codeception\Commands
 */
abstract class BaseCommand extends \FPFProVendor\Composer\Command\BaseCommand
{
    /**
     * @param string $command
     * @param OutputInterface $output
     */
    protected function execAndOutput($command, \FPFProVendor\Symfony\Component\Console\Output\OutputInterface $output)
    {
        \passthru($command);
    }
}
