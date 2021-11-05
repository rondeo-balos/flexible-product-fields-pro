<?php

namespace FPFProVendor\WPDesk\Helper\Integration;

use FPFProVendor\WPDesk\Helper\Page\SettingsPage;
use FPFProVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FPFProVendor\WPDesk\PluginBuilder\Plugin\HookableCollection;
use FPFProVendor\WPDesk\PluginBuilder\Plugin\HookableParent;
/**
 * Integrates WP Desk main settings page with WordPress
 *
 * @package WPDesk\Helper
 */
class SettingsIntegration implements \FPFProVendor\WPDesk\PluginBuilder\Plugin\Hookable, \FPFProVendor\WPDesk\PluginBuilder\Plugin\HookableCollection
{
    use HookableParent;
    /** @var SettingsPage */
    private $settings_page;
    public function __construct(\FPFProVendor\WPDesk\Helper\Page\SettingsPage $settingsPage)
    {
        $this->add_hookable($settingsPage);
    }
    /**
     * @return void
     */
    public function hooks()
    {
        $this->hooks_on_hookable_objects();
    }
}
