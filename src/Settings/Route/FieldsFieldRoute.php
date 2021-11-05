<?php

namespace WPDesk\FPF\Pro\Settings\Route;

use WPDesk\FPF\Free\Field\FieldData;
use WPDesk\FPF\Free\Settings\Option\FieldLabelOption;
use WPDesk\FPF\Free\Settings\Option\FieldNameOption;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FPF\Free\Settings\Route\RouteAbstract;
use WPDesk\FPF\Pro\Field\Type\CheckboxType;
use WPDesk\FPF\Pro\Field\Type\RadioImagesType;
use WPDesk\FPF\Pro\Field\Type\RadioType;
use WPDesk\FPF\Pro\Field\Type\SelectType;

/**
 * {@inheritdoc}
 */
class FieldsFieldRoute extends RouteAbstract {

	const REST_API_ROUTE = 'fields-field';

	/**
	 * List of supported field types.
	 *
	 * @var array
	 */
	public static $supported_field_types = [
		CheckboxType::FIELD_TYPE,
		SelectType::FIELD_TYPE,
		RadioType::FIELD_TYPE,
		RadioImagesType::FIELD_TYPE,
	];

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
		$settings       = $this::update_fields_settings( $params['form_section'] ?? '', $params['form_fields'] ?? [] );
		$excluded_field = $params['form_field_name'] ?? '';
		$values         = [];
		foreach ( $settings as $section_fields ) {
			foreach ( $section_fields as $field ) {
				if ( ( $field[ FieldNameOption::FIELD_NAME ] === $excluded_field )
					|| ! in_array( $field[ FieldTypeOption::FIELD_NAME ] ?? '', self::$supported_field_types, true ) ) {
					continue;
				}
				$values[ $field[ FieldNameOption::FIELD_NAME ] ] = sprintf(
					'%s (%s)',
					$field[ FieldLabelOption::FIELD_NAME ],
					$field[ FieldNameOption::FIELD_NAME ]
				);
			}
		}
		return $values;
	}

	/**
	 * Returns updated fields settings using posted data.
	 *
	 * @param string $section_name     Name of section.
	 * @param array  $section_settings Settings of section.
	 *
	 * @return array Fields settings.
	 */
	public static function update_fields_settings( string $section_name, array $section_settings ): array {
		$section_fields = [];
		foreach ( $section_settings as $field_data ) {
			$new_field_data = FieldData::get_field_data( $field_data, false );
			if ( ! $new_field_data ) {
				continue;
			}
			$section_fields[ $field_data[ FieldNameOption::FIELD_NAME ] ] = $new_field_data;
		}

		$settings[ $section_name ] = $section_fields;
		return $settings;
	}
}
