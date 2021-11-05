<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;
use WPDesk\FPF\Free\Settings\Validation\Error\FieldRequiredError;
use WPDesk\FPF\Pro\Settings\Route\FieldsFieldRoute;

/**
 * {@inheritdoc}
 */
class LogicRulesFieldOption extends OptionAbstract {

	const FIELD_NAME = 'field';

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
		return self::FIELD_TYPE_SELECT;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Field', 'flexible-product-fields-pro' );
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
	public function get_endpoint_route(): string {
		return FieldsFieldRoute::REST_API_ROUTE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_endpoint_autorefreshed(): bool {
		return true;
	}
}
