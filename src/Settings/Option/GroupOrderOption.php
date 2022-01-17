<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Validation\Error\FieldRequiredError;

/**
 * {@inheritdoc}
 */
class GroupOrderOption extends OptionAbstract {

	const FIELD_NAME = 'menu_order';

	/**
	 * {@inheritdoc}
	 */
	public function get_option_name(): string {
		return self::FIELD_NAME;
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
		return __( 'Order Group', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_input_atts(): array {
		return [
			'step' => '1',
		];
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
	public function get_default_value() {
		return '0';
	}
}
