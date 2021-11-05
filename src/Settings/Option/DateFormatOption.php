<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;
use WPDesk\FPF\Free\Settings\Validation\Error\FieldRequiredError;

/**
 * {@inheritdoc}
 */
class DateFormatOption extends OptionAbstract {

	const FIELD_NAME = 'date_format';

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
		return __( 'Date format', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_label_tooltip(): string {
		return __( 'Enter the WordPress date format.', 'flexible-product-fields-pro' );
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
		return 'dd.mm.yy';
	}
}
