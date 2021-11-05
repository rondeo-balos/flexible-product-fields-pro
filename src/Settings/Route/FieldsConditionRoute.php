<?php

namespace WPDesk\FPF\Pro\Settings\Route;

use WPDesk\FPF\Free\Settings\Option\FieldNameOption;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FPF\Free\Settings\Route\RouteAbstract;
use WPDesk\FPF\Pro\Field\Type\CheckboxType;
use WPDesk\FPF\Pro\Field\Type\RadioImagesType;
use WPDesk\FPF\Pro\Field\Type\RadioType;
use WPDesk\FPF\Pro\Field\Type\SelectType;
use WPDesk\FPF\Pro\Settings\Option\LogicRulesFieldOption;

/**
 * {@inheritdoc}
 */
class FieldsConditionRoute extends RouteAbstract {

	const REST_API_ROUTE = 'fields-condition';

	/**
	 * {@inheritdoc}
	 */
	public function get_endpoint_route(): string {
		return self::REST_API_ROUTE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_endpoint_response( array $params ) {
		$settings   = FieldsFieldRoute::update_fields_settings( $params['form_section'] ?? '', $params['form_fields'] ?? [] );
		$field_name = $params['form_values'][ LogicRulesFieldOption::FIELD_NAME ] ?? '';
		$values     = [];
		foreach ( $settings as $section_fields ) {
			foreach ( $section_fields as $field ) {
				if ( ( $field[ FieldNameOption::FIELD_NAME ] !== $field_name )
					|| ! in_array( $field[ FieldTypeOption::FIELD_NAME ] ?? '', FieldsFieldRoute::$supported_field_types, true ) ) {
					continue;
				}
				$values += $this->get_values_for_field( $field );
			}
		}
		return $values;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values_for_field( array $field_data ): array {
		switch ( $field_data[ FieldTypeOption::FIELD_NAME ] ) {
			case CheckboxType::FIELD_TYPE:
			case RadioType::FIELD_TYPE:
			case RadioImagesType::FIELD_TYPE:
			case SelectType::FIELD_TYPE:
				return [
					'is'     => __( 'is', 'flexible-product-fields-pro' ),
					'is_not' => __( 'is not', 'flexible-product-fields-pro' ),
				];
		}
		return [];
	}
}
