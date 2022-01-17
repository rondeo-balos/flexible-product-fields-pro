<?php

namespace FPFProVendor\WPDesk\Composer\Codeception;

use FPFProVendor\WPDesk\Composer\Codeception\Commands\CreateCodeceptionTests;
use FPFProVendor\WPDesk\Composer\Codeception\Commands\PrepareCodeceptionDb;
use FPFProVendor\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTests;
use FPFProVendor\WPDesk\Composer\Codeception\Commands\PrepareParallelCodeceptionTests;
use FPFProVendor\WPDesk\Composer\Codeception\Commands\PrepareWordpressForCodeception;
use FPFProVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests;
use FPFProVendor\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTests;
/**
 * Links plugin commands handlers to composer.
 */
class CommandProvider implements \FPFProVendor\Composer\Plugin\Capability\CommandProvider
{
    public function getCommands()
    {
        return [new \FPFProVendor\WPDesk\Composer\Codeception\Commands\CreateCodeceptionTests(), new \FPFProVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests(), new \FPFProVendor\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTests(), new \FPFProVendor\WPDesk\Composer\Codeception\Commands\PrepareCodeceptionDb(), new \FPFProVendor\WPDesk\Composer\Codeception\Commands\PrepareWordpressForCodeception(), new \FPFProVendor\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTests(), new \FPFProVendor\WPDesk\Composer\Codeception\Commands\PrepareParallelCodeceptionTests()];
    }
}
