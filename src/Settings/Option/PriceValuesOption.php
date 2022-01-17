<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Option\OptionsOption;
use WPDesk\FPF\Free\Settings\Option\OptionsValueOption;
use WPDesk\FPF\Free\Settings\Tab\PricingTab;

/**
 * {@inheritdoc}
 */
class PriceValuesOption extends OptionAbstract {

	const FIELD_NAME = 'price_values';

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
		return self::FIELD_TYPE_REPEATER;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_row_label(): string {
		/* translators: %s: option value */
		return __( 'Pricing options for "%s"', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_name_to_rows(): string {
		return OptionsOption::FIELD_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return [
			'_value' => [
				PriceTypeOption::FIELD_NAME  => '',
				PriceValueOption::FIELD_NAME => '',
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_children(): array {
		return [
			PriceTypeOption::FIELD_NAME  => new PriceTypeOption(),
			PriceValueOption::FIELD_NAME => new PriceValueOption(),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function update_field_data( array $field_data, array $field_settings ): array {
		$option_name = $this->get_option_name();
		if ( isset( $field_settings[ $option_name ] ) ) {
			return parent::update_field_data( $field_data, $field_settings );
		}

		$options      = $field_settings[ OptionsOption::FIELD_NAME ] ?? [];
		$price_values = [];

		foreach ( $options as $option_row ) {
			$price_values[ $option_row[ OptionsValueOption::FIELD_NAME ] ] = [
				PriceTypeOption::FIELD_NAME  => $option_row[ PriceTypeOption::FIELD_NAME ] ?? '',
				PriceValueOption::FIELD_NAME => $option_row[ PriceValueOption::FIELD_NAME ] ?? '',
			];
		}

		$field_data[ $option_name ] = $price_values;
		return $field_data;
	}
}
