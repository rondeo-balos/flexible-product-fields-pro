<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\PricingTab;

/**
 * {@inheritdoc}
 */
class PriceTypeOption extends OptionAbstract {

	const FIELD_NAME = 'price_type';

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
		return self::FIELD_TYPE_SELECT;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Price type', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values(): array {
		return [
			''        => __( 'None', 'flexible-product-fields-pro' ),
			'fixed'   => __( 'Fixed', 'flexible-product-fields-pro' ),
			'percent' => __( 'Percent', 'flexible-product-fields-pro' ),
		];
	}
}
