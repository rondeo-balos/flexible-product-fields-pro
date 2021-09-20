<?php

use WPDesk\FPF\Pro\Plugin as PluginPro;

/**
 * Class Flexible_Product_Fields_PRO_Plugin
 */
class Flexible_Product_Fields_PRO_Plugin extends \FPFProVendor\WPDesk\PluginBuilder\Plugin\AbstractPlugin {

	/**
	 * Scripts version string.
	 *
	 * @var string
	 */
	private $script_version = '9';

	/**
	 * Instance of new version main class of plugin.
	 *
	 * @var PluginPro
	 */
	private $plugin_pro;

	/**
	 * Flexible_Product_Fields_PRO_Plugin constructor.
	 *
	 * @param FPFProVendor\WPDesk_Plugin_Info $plugin_info Plugin data.
	 */
	public function __construct( FPFProVendor\WPDesk_Plugin_Info $plugin_info ) {
		$this->plugin_info = $plugin_info;
		parent::__construct( $this->plugin_info );
		$this->plugin_pro = new PluginPro( $plugin_info, $this );
	}

	/**
	 * Init base variables for plugin
	 */
	public function init_base_variables() {
		$this->plugin_url = $this->plugin_info->get_plugin_url();

		$this->plugin_path = $this->plugin_info->get_plugin_dir();
		$this->template_path = $this->plugin_info->get_text_domain();

		$this->plugin_text_domain = $this->plugin_info->get_text_domain();
		$this->plugin_namespace = $this->plugin_info->get_text_domain();
		$this->template_path = $this->plugin_info->get_text_domain();
		$this->default_settings_tab = 'main';

		$this->settings_url = admin_url( 'edit.php?post_type=fpf_fields' );

		$this->default_view_args = array(
			'plugin_url' => $this->get_plugin_url()
		);
	}

	/**
	 * Initializes plugin functionality.
	 */
	public function init() {
		$this->plugin_pro->load_action_init();
	}

	/**
	 * Initializes plugin functionality after "flexible_checkout_fields/init" action.
	 */
	public function load_after_action_init() {
		parent::init();
		$this->fpf_pro = new FPF_PRO( $this );
		$duplicate     = new FPF_PRO_Duplicate( $this );
		$duplicate->hooks();
		$this->plugin_pro->hooks();
	}

	/**
	 * Enqueue scripts
	 */
	public function wp_enqueue_scripts() {
		if ( ! defined( 'WC_VERSION' ) ) {
			return;
		}
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( is_product() ) {
			wp_enqueue_style( 'fpf-pro-front', trailingslashit( $this->get_plugin_assets_url() ) . '/css/new-front.css', [], $this->script_version );

			add_action( 'wp_footer', [ $this, 'print_front_localize' ], 0 );
			wp_enqueue_script( 'fpf-pro-front', trailingslashit( $this->get_plugin_assets_url() ) . '/js/new-front.js', [], $this->script_version, true );

			wp_enqueue_script( 'flexible_product_fields_front_js', trailingslashit( $this->get_plugin_assets_url() ) . '/js/front.js', array( 'jquery' ), $this->script_version );
		}
	}

	public function print_front_localize() {
		$locales = [
			'days' =>        explode( ',', __( 'Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday', 'flexible-product-fields-pro' ) ),
			'daysShort' =>   explode( ',', __( 'Sun,Mon,Tue,Wed,Thu,Fri,Sat', 'flexible-product-fields-pro' ) ),
			'daysMin' =>     explode( ',', __( 'Su,Mo,Tu,We,Th,Fr,Sa', 'flexible-product-fields-pro' ) ),
			'months' =>      explode( ',', __( 'January,February,March,April,May,June,July,August,September,October,November,December', 'flexible-product-fields-pro' ) ),
			'monthsShort' => explode( ',', __( 'Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec', 'flexible-product-fields-pro' ) ),
			'today' =>       __( 'Today', 'flexible-product-fields-pro' ),
			'clear' =>       __( 'Clear', 'flexible-product-fields-pro' ),
			'titleFormat' => 'MM y',
			'format' =>      'mm/dd/yyyy',
			'weekstart' =>   0,
		];
		?>
			<script>
				window.fpf_pro_datepicker_locales = <?php echo json_encode( $locales ); ?>
			</script>
		<?php
	}

	public function wp_localize_jquery_ui_datepicker() {
		global $wp_locale;
		global $wp_version;

		if ( ! wp_script_is( 'jquery-ui-datepicker', 'enqueued' ) || version_compare( $wp_version, '4.6' ) != -1 ) {
			return;
		}

		// Convert the PHP date format into jQuery UI's format.
		$datepicker_date_format = str_replace(
			array(
				'd', 'j', 'l', 'z', // Day.
				'F', 'M', 'n', 'm', // Month.
				'Y', 'y'            // Year.
			),
			array(
				'dd', 'd', 'DD', 'o',
				'MM', 'M', 'm', 'mm',
				'yy', 'y',
			),
			get_option( 'date_format' )
		);

		$datepicker_defaults = wp_json_encode( array(
			'closeText'       => __( 'Close' ),
			'currentText'     => __( 'Today' ),
			'monthNames'      => array_values( $wp_locale->month ),
			'monthNamesShort' => array_values( $wp_locale->month_abbrev ),
			'nextText'        => __( 'Next' ),
			'prevText'        => __( 'Previous' ),
			'dayNames'        => array_values( $wp_locale->weekday ),
			'dayNamesShort'   => array_values( $wp_locale->weekday_abbrev ),
			'dayNamesMin'     => array_values( $wp_locale->weekday_initial ),
			'dateFormat'      => $datepicker_date_format,
			'firstDay'        => absint( get_option( 'start_of_week' ) ),
			'isRTL'           => $wp_locale->is_rtl(),
		) );

		wp_add_inline_script( 'jquery-ui-datepicker', "jQuery(document).ready(function(jQuery){jQuery.datepicker.setDefaults({$datepicker_defaults});});" );
	}

	public function links_filter( $links ) {
		$plugin_links = array(
			'<a href="' . $this->settings_url . '">' . __( 'Settings', 'flexible-product-fields-pro' ) . '</a>',
			'<a href="' . esc_url( apply_filters( 'flexible_product_fields/short_url', 'https://wpde.sk/fpf-settings-row-action-docs', 'fpf-settings-row-action-docs' ) ) . '" target="_blank">' . __( 'Docs', 'flexible-product-fields' ) . '</a>',
			'<a href="' . esc_url( apply_filters( 'flexible_product_fields/short_url', 'https://wpde.sk/fpf-settings-row-action-support-pro', 'fpf-settings-row-action-support-pro' ) ) . '" target="_blank">' . __( 'Support', 'flexible-product-fields' ) . '</a>',
		);

		return array_merge( $plugin_links, $links );
	}
}

