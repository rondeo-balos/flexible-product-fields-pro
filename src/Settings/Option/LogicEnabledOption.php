<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;

/**
 * {@inheritdoc}
 */
class LogicEnabledOption extends OptionAbstract {

	const FIELD_NAME = 'logic';

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
		return self::FIELD_TYPE_CHECKBOX;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Conditional logic', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_label_tooltip(): string {
		return __( 'Add at least one field containing values e.g. Checkbox. Then this field will show as an available rule for conditional logic.', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_label_tooltip_url(): string {
		return apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-tooltip-docs-conditional-logic' );
	}
}
