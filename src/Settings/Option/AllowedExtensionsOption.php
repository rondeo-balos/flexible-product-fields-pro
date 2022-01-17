<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;
use WPDesk\FPF\Free\Settings\Validation\Error\FieldRequiredError;

/**
 * {@inheritdoc}
 */
class AllowedExtensionsOption extends OptionAbstract {

	const FIELD_NAME = 'allowed_extensions';

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
		return self::FIELD_TYPE_SELECT_MULTI;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Allowed file types', 'flexible-product-fields-pro' );
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
		$mime_types = wp_get_mime_types();
		$values     = [];
		foreach ( $mime_types as $extensions => $mime_type ) {
			$values[ $mime_type ] = sprintf(
				'.%1$s (%2$s)',
				implode( ', .', explode( '|', $extensions ) ),
				$mime_type
			);
		}

		return $values;
	}
}
