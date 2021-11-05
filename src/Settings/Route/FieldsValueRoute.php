<?php

namespace WPDesk\FPF\Pro\Settings\Route;

use WPDesk\FPF\Free\Field\FieldData;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FPF\Free\Settings\Option\OptionsLabelOption;
use WPDesk\FPF\Free\Settings\Option\OptionsOption;
use WPDesk\FPF\Free\Settings\Option\OptionsValueOption;
use WPDesk\FPF\Pro\Field\Type\CheckboxType;
use WPDesk\FPF\Pro\Field\Type\RadioImagesType;
use WPDesk\FPF\Pro\Field\Type\RadioType;
use WPDesk\FPF\Pro\Field\Type\SelectType;

/**
 * {@inheritdoc}
 */
class FieldsValueRoute extends FieldsConditionRoute {

	const REST_API_ROUTE = 'fields-value';

	/**
	 * {@inheritdoc}
	 */
	public function get_endpoint_route(): string {
		return self::REST_API_ROUTE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values_for_field( array $field_data ): array {
		switch ( $field_data[ FieldTypeOption::FIELD_NAME ] ) {
			case CheckboxType::FIELD_TYPE:
				return [
					'checked'   => __( 'checked', 'flexible-product-fields-pro' ),
					'unchecked' => __( 'unchecked', 'flexible-product-fields-pro' ),
				];
			case RadioType::FIELD_TYPE:
			case RadioImagesType::FIELD_TYPE:
			case SelectType::FIELD_TYPE:
				$field_args = FieldData::get_field_data( $field_data );
				$options    = $field_args[ OptionsOption::FIELD_NAME ] ?? [];
				if ( ! $field_args || ! $options ) {
					return [];
				}
				return array_combine(
					array_column( $options, OptionsValueOption::FIELD_NAME ),
					array_column( $options, OptionsLabelOption::FIELD_NAME )
				);
		}
		return [];
	}
}
