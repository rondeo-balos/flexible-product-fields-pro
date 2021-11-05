<?php

namespace FPFProVendor\WPDesk\Composer\Codeception;

use FPFProVendor\Composer\Composer;
use FPFProVendor\Composer\IO\IOInterface;
use FPFProVendor\Composer\Plugin\Capable;
use FPFProVendor\Composer\Plugin\PluginInterface;
/**
 * Composer plugin.
 *
 * @package WPDesk\Composer\Codeception
 */
class Plugin implements \FPFProVendor\Composer\Plugin\PluginInterface, \FPFProVendor\Composer\Plugin\Capable
{
    /**
     * @var Composer
     */
    private $composer;
    /**
     * @var IOInterface
     */
    private $io;
    public function activate(\FPFProVendor\Composer\Composer $composer, \FPFProVendor\Composer\IO\IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    /**
     * @inheritDoc
     */
    public function deactivate(\FPFProVendor\Composer\Composer $composer, \FPFProVendor\Composer\IO\IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    /**
     * @inheritDoc
     */
    public function uninstall(\FPFProVendor\Composer\Composer $composer, \FPFProVendor\Composer\IO\IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    public function getCapabilities()
    {
        return [\FPFProVendor\Composer\Plugin\Capability\CommandProvider::class => \FPFProVendor\WPDesk\Composer\Codeception\CommandProvider::class];
    }
}
