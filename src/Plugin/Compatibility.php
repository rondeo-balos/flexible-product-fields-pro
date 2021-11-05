<?php
/**
 * .
 *
 * @package WPDesk\FPF\Pro
 */

namespace WPDesk\FPF\Pro\Plugin;

use FPFProVendor\WPDesk\PluginBuilder\Plugin\PluginAccess;
use FPFProVendor\WPDesk\View\Renderer\SimplePhpRenderer;
use FPFProVendor\WPDesk\View\Resolver\DirResolver;

/**
 * .
 */
class Compatibility {

	use PluginAccess;

	const COMPATIBILITY_TRANSIENT_NAME = 'fpf_compatibility_email';

	/**
	 * Version of plugin core (for compatibility with main plugin).
	 *
	 * @var string
	 */
	private $version_dev = FLEXIBLE_PRODUCT_FIELDS_PRO_VERSION_DEV;

	/**
	 * Class object for template rendering.
	 *
	 * @var SimplePhpRenderer
	 */
	private $renderer;

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->set_renderer();
	}

	/**
	 * Init class for template rendering.
	 */
	private function set_renderer() {
		$this->renderer = new SimplePhpRenderer( new DirResolver( dirname( dirname( __DIR__ ) ) . '/templates' ) );
	}

	/**
	 * Checks compatibility this plugin core to main plugin core.
	 * In case of compatibility problems, displays Admin Notices.
	 *
	 * In case of compatibility problems, displays Admin Notices.
	 *
	 * @param \WPDesk\FPF\Free\Integration\Integrator $integrator Handler for integration.
	 *
	 * @return bool Status if plugin is compatible.
	 */
	public function check_plugin_compatibility( $integrator ): bool {
		$version = $integrator->get_version_dev();
		if ( ( ! $integrator instanceof \WPDesk\FPF\Free\Integration\Integrator ) || ! $version ) {
			return false;
		}

		if ( $this->check_compatibility_version_minor( $version ) ) {
			return true;
		} elseif ( ! $this->check_compatibility_version_major( $version ) ) {
			add_action( 'admin_notices', [ $this, 'show_error_about_compatibility' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'load_styles_for_notice' ] );
			$this->send_email_to_admin( $this->get_notice_error_title(), $this->get_notice_error_content() );
			return false;
		} else {
			add_action( 'admin_notices', [ $this, 'show_warning_about_compatibility' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'load_styles_for_notice' ] );
			$this->send_email_to_admin( $this->get_notice_warning_title(), $this->get_notice_warning_content() );
			return true;
		}
	}

	/**
	 * Compares major version of this plugin core to version of main plugin core.
	 *
	 * @param string $main_version Version of main plugin core.
	 *
	 * @return bool Status if plugin is compatible.
	 */
	private function check_compatibility_version_major( string $main_version ): bool {
		$version_current_parts = explode( '.', $this->version_dev );
		$version_main_parts    = explode( '.', $main_version );
		$version_current_major = $version_current_parts[0];
		$version_main_major    = $version_main_parts[0];
		$version_current_minor = implode( '.', array_slice( $version_current_parts, 0, 2 ) );
		$version_main_minor    = implode( '.', array_slice( $version_main_parts, 0, 2 ) );

		return ( version_compare( $version_current_major, $version_main_major, '==' )
			&& version_compare( $version_current_minor, $version_main_minor, '<=' ) );
	}

	/**
	 * Compares minor version of this plugin core to version of main plugin core.
	 *
	 * @param string $main_version Version of main plugin core.
	 *
	 * @return bool Status if plugin is compatible.
	 */
	private function check_compatibility_version_minor( string $main_version ): bool {
		$version_current_parts = explode( '.', $this->version_dev );
		$version_main_parts    = explode( '.', $main_version );
		$version_current_minor = implode( '.', array_slice( $version_current_parts, 0, 2 ) );
		$version_main_minor    = implode( '.', array_slice( $version_main_parts, 0, 2 ) );

		return version_compare( $version_current_minor, $version_main_minor, '==' );
	}

	/**
	 * Enqueues styles in WordPress Admin Dashboard.
	 *
	 * @internal
	 */
	public function load_styles_for_notice() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';

		wp_register_style(
			'fpf-pro-notice',
			trailingslashit( $this->plugin->get_plugin_assets_url() ) . 'css/admin-notice' . $suffix,
			[],
			$this->plugin->get_script_version()
		);
		wp_enqueue_style( 'fpf-pro-notice' );
	}

	/**
	 * Initializes integration for 3rd party plugins.
	 *
	 * @internal
	 */
	public function show_warning_about_compatibility() {
		echo $this->renderer->render( // phpcs:ignore
			'notices/compatibility-error',
			[
				'notice_title'   => $this->get_notice_warning_title(), // phpcs:ignore
				'notice_content' => $this->get_notice_warning_content(), // phpcs:ignore
			]
		);
	}

	/**
	 * Initializes integration for 3rd party plugins.
	 *
	 * @internal
	 */
	public function show_error_about_compatibility() {
		echo $this->renderer->render( // phpcs:ignore
			'notices/compatibility-error',
			[
				'notice_title'   => $this->get_notice_error_title(), // phpcs:ignore
				'notice_content' => $this->get_notice_error_content(), // phpcs:ignore
			]
		);
	}

	/**
	 * Returns title of compatibility warning.
	 *
	 * @return string Notice title.
	 */
	private function get_notice_warning_title(): string {
		return esc_attr__( 'Flexible Product Fields and Flexible Product Fields PRO plugins are not compatible with each other!', 'flexible-product-fields-pro' );
	}

	/**
	 * Returns title of compatibility error.
	 *
	 * @return string Notice title.
	 */
	private function get_notice_error_title(): string {
		return $this->get_notice_warning_title();
	}

	/**
	 * Returns content of compatibility warning.
	 *
	 * @return string Notice title.
	 */
	private function get_notice_warning_content(): string {
		return sprintf(
		/* translators: %s: break-line char */
			__( 'Update both plugins to the latest versions for trouble-free use of all functionalities. Working with plugins now comes with limitations and risks. %sWe improve both versions on a regular basis. Updating the free and PRO versions at the same time guarantees their correct operation.', 'flexible-product-fields-pro' ),
			'<br>'
		);
	}

	/**
	 * Returns content of compatibility error.
	 *
	 * @return string Notice title.
	 */
	private function get_notice_error_content(): string {
		return sprintf(
		/* translators: %s: break-line char */
			__( 'Update both plugins to the latest versions to use all the features of the PRO plugin. This plugin has now been deactivated as it is not compatible. %sWe improve both versions on a regular basis. Updating the free and PRO versions at the same time guarantees their correct operation.', 'flexible-product-fields-pro' ),
			'<br>'
		);
	}

	/**
	 * Sends email to administrator when there is compatibility issue.
	 *
	 * @param string $notice_title   Title of notice.
	 * @param string $notice_content Content of notice.
	 */
	private function send_email_to_admin( string $notice_title, string $notice_content ) {
		$transient_value = get_transient( self::COMPATIBILITY_TRANSIENT_NAME );
		if ( $transient_value !== false ) {
			return;
		}
		set_transient( self::COMPATIBILITY_TRANSIENT_NAME, $this->version_dev, WEEK_IN_SECONDS );

		$data = $this->get_email_data( $notice_title, $notice_content );
		wp_mail( $data['to'], $data['subject'], $data['message'] );
	}

	/**
	 * Returns data of email when there is compatibility issue.
	 *
	 * @param string $notice_title   Title of notice.
	 * @param string $notice_content Content of notice.
	 *
	 * @return array Data of email (keys: to, subject, message).
	 */
	private function get_email_data( string $notice_title, string $notice_content ): array {
		$subject = sprintf(
			'[%1$s] %2$s',
			get_option( 'blogname' ),
			__( 'Flexible Product Fields PRO update needed!', 'flexible-product-fields-pro' )
		);

		$body   = [];
		$body[] = $notice_title;
		$body[] = preg_replace( '/\<br([\s\/]+)?\>/', "\n", $notice_content );
		$body[] = sprintf(
		/* translators: %s: Plugins screen URL. */
			__( 'To manage plugins on your site, visit the Plugins page: %s', 'flexible-product-fields-pro' ),
			"\n" . admin_url( 'plugins.php' )
		);

		return [
			'to'      => get_site_option( 'admin_email' ),
			'subject' => wp_specialchars_decode( $subject, ENT_QUOTES ),
			'message' => implode( "\n\n", $body ),
		];
	}
}
