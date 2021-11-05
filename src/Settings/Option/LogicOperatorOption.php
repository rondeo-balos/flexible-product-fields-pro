<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;
use WPDesk\FPF\Free\Settings\Validation\Error\FieldRequiredError;

/**
 * {@inheritdoc}
 */
class LogicOperatorOption extends OptionAbstract {

	const FIELD_NAME = 'logic_operator';

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
		return LogicTab::TAB_NAME;
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
		return __( 'Show this field if', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_regexes_to_display(): array {
		return [
			LogicEnabledOption::FIELD_NAME => '^1$',
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
	public function get_values(): array {
		return [
			'and' => __( 'All rules match (and)', 'flexible-product-fields-pro' ),
			'or'  => __( 'One or more rules match (or)', 'flexible-product-fields-pro' ),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return 'or';
	}
}
