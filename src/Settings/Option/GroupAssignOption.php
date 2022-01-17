<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\GroupAssignOption as GroupAssignOptionDefault;

/**
 * {@inheritdoc}
 */
class GroupAssignOption extends GroupAssignOptionDefault {

	const OPTION_ASSIGN_TO_PRODUCT  = 'product';
	const OPTION_ASSIGN_TO_CATEGORY = 'category';
	const OPTION_ASSIGN_TO_TAG      = 'tag';
	const OPTION_ASSIGN_TO_ALL      = 'all';

	/**
	 * {@inheritdoc}
	 */
	public function get_validation_rules(): array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values(): array {
		return [
			self::OPTION_ASSIGN_TO_PRODUCT  => __( 'Product', 'flexible-product-fields-pro' ),
			self::OPTION_ASSIGN_TO_CATEGORY => __( 'Category', 'flexible-product-fields-pro' ),
			self::OPTION_ASSIGN_TO_TAG      => __( 'Tag', 'flexible-product-fields-pro' ),
			self::OPTION_ASSIGN_TO_ALL      => __( 'All products', 'flexible-product-fields-pro' ),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return self::OPTION_ASSIGN_TO_PRODUCT;
	}
}
