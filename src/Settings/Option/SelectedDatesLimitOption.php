<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;

/**
 * {@inheritdoc}
 */
class SelectedDatesLimitOption extends OptionAbstract {

	const FIELD_NAME          = 'max_dates';
	const DEFAULT_DATES_LIMIT = '1';

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
		return self::FIELD_TYPE_NUMBER;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Selected days limit', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_input_atts(): array {
		return [
			'min'  => '1',
			'step' => '1',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return self::DEFAULT_DATES_LIMIT;
	}

	/**
	 * {@inheritdoc}
	 */
	public function sanitize_option_value( $field_value ) {
		if ( $field_value === '' ) {
			return '';
		}
		return intval( $field_value );
	}
}
