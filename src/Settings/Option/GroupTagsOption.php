<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\GroupProductsOption;
use WPDesk\FPF\Free\Settings\Validation\Error\FieldRequiredError;
use WPDesk\FPF\Pro\Settings\Route\ProductsTagsRoute;

/**
 * {@inheritdoc}
 */
class GroupTagsOption extends GroupProductsOption {

	const FIELD_NAME = 'tag_id';

	/**
	 * {@inheritdoc}
	 */
	public function get_option_name(): string {
		return self::FIELD_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Select tags', 'flexible-product-fields-pro' );
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
	public function get_options_regexes_to_display(): array {
		return [
			GroupAssignOption::FIELD_NAME => '^' . GroupAssignOption::OPTION_ASSIGN_TO_TAG . '$',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_endpoint_route(): string {
		return ProductsTagsRoute::REST_API_ROUTE;
	}
}
