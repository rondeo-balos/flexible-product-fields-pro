<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;

/**
 * {@inheritdoc}
 */
class ExcludedWeekDaysOption extends OptionAbstract {

	const FIELD_NAME = 'days_excluded';

	/**
	 * {@inheritdoc}
	 */
	public function get_option_name(): string {
		return self::FIELD_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_tab(): string {
		return AdvancedTab::TAB_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return self::FIELD_TYPE_SELECT_MULTI;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Excluded days of week', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values(): array {
		return [
			'0' => __( 'Sunday', 'flexible-product-fields-pro' ),
			'1' => __( 'Monday', 'flexible-product-fields-pro' ),
			'2' => __( 'Tuesday', 'flexible-product-fields-pro' ),
			'3' => __( 'Wednesday', 'flexible-product-fields-pro' ),
			'4' => __( 'Thursday', 'flexible-product-fields-pro' ),
			'5' => __( 'Friday', 'flexible-product-fields-pro' ),
			'6' => __( 'Saturday', 'flexible-product-fields-pro' ),
		];
	}
}
