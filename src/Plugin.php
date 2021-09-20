<?php
/**
 * .
 *
 * @package WPDesk\FPF\Pro
 */

namespace WPDesk\FPF\Pro;

use FPFProVendor\WPDesk_Plugin_Info;
use FPFProVendor\WPDesk\PluginBuilder\Plugin\AbstractPlugin;
use FPFProVendor\WPDesk\PluginBuilder\Plugin\HookableCollection;
use FPFProVendor\WPDesk\PluginBuilder\Plugin\HookableParent;
use WPDesk\FPF\Pro\Plugin;

/**
 * Main plugin class. The most important flow decisions are made here.
 */
class Plugin extends AbstractPlugin implements HookableCollection {

	use HookableParent;

	/**
	 * Scripts version.
	 *
	 * @var string
	 */
	private $script_version = '1';

	/**
	 * Instance of old version main class of plugin.
	 *
	 * @var \Flexible_Product_Fields_PRO_Plugin
	 */
	private $plugin_old;

	/**
	 * Plugin constructor.
	 *
	 * @param WPDesk_Plugin_Info                  $plugin_info Plugin info.
	 * @param \Flexible_Product_Fields_PRO_Plugin $plugin_old Main plugin.
	 */
	public function __construct( WPDesk_Plugin_Info $plugin_info, \Flexible_Product_Fields_PRO_Plugin $plugin_old ) {
		parent::__construct( $plugin_info );

		$this->plugin_url       = $this->plugin_info->get_plugin_url();
		$this->plugin_namespace = $this->plugin_info->get_text_domain();
		$this->script_version   = $plugin_info->get_version();
		$this->plugin_old       = $plugin_old;
	}

	/**
	 * Initializes plugin external state after "flexible_product_fields/init" action.
	 *
	 * In case of compatibility problems, displays Admin Notices.
	 *
	 * @return void
	 */
	public function load_action_init() {
		add_action(
			'flexible_product_fields/init',
			function( $integrator ) {
				$compatibility = new Plugin\Compatibility();
				$compatibility->set_plugin( $this );

				if ( $compatibility->check_plugin_compatibility( $integrator ) ) {
					$this->plugin_old->load_after_action_init();
				}
			}
		);
	}

	/**
	 * Initializes plugin external state.
	 *
	 * The plugin internal state is initialized in the constructor and the plugin should be internally consistent after creation.
	 * The external state includes hooks execution, communication with other plugins, integration with WC etc.
	 *
	 * @return void
	 */
	public function init() {
	}

	/**
	 * Integrate with WordPress and with other plugins using action/filter system.
	 *
	 * @return void
	 */
	public function hooks() {
		$this->hooks_on_hookable_objects();
	}

	/**
	 * Get script version.
	 *
	 * @return string;
	 */
	public function get_script_version() {
		return $this->script_version;
	}
}
