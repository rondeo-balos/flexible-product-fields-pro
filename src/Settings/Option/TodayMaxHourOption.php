<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;
use WPDesk\FPF\Pro\Settings\Validation\Error\InvalidHourFormatError;

/**
 * {@inheritdoc}
 */
class TodayMaxHourOption extends OptionAbstract {

	const FIELD_NAME = 'today_max_hour';

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
		return self::FIELD_TYPE_TEXT;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Time of day closing', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_label_tooltip(): string {
		return __( 'Enter the value in the HH:MM format.', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_validation_rules(): array {
		return [
			'^$|^[0-9]{2}:[0-9]{2}$' => new InvalidHourFormatError(),
		];
	}
}
