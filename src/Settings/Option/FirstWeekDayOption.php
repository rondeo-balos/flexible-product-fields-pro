<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;
use WPDesk\FPF\Free\Settings\Validation\Error\FieldRequiredError;

/**
 * {@inheritdoc}
 */
class FirstWeekDayOption extends OptionAbstract {

	const FIELD_NAME             = 'week_start';
	const DEFAULT_FIRST_WEEK_DAY = '0';

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
		return self::FIELD_TYPE_SELECT;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'First day of week', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_validation_rules(): array {
		return [
			'^.{1,}$' => new FieldRequiredError(),
		];
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

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return self::DEFAULT_FIRST_WEEK_DAY;
	}
}
