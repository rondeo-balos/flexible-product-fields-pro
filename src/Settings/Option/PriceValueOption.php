<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\PricingTab;

/**
 * {@inheritdoc}
 */
class PriceValueOption extends OptionAbstract {

	const FIELD_NAME = 'price';

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
		return PricingTab::TAB_NAME;
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
		return __( 'Price', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_label_tooltip(): string {
		return __( 'It is possible to customize the labels that contain the brackets with the price.', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_label_tooltip_url(): string {
		return apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-tooltip-docs-pricing' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_input_atts(): array {
		return [
			'step' => '0.01',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_regexes_to_display(): array {
		return [
			PriceTypeOption::FIELD_NAME => '^.{1,}$',
		];
	}
}
