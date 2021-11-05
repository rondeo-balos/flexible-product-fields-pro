<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;
use WPDesk\FPF\Free\Settings\Validation\Error\FieldRequiredError;
use WPDesk\FPF\Pro\Settings\Route\FieldsConditionRoute;

/**
 * {@inheritdoc}
 */
class LogicRulesConditionOption extends OptionAbstract {

	const FIELD_NAME = 'compare';

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
		return __( 'Condition', 'flexible-product-fields-pro' );
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
			LogicRulesFieldOption::FIELD_NAME => '^.{1,}$',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_endpoint_route(): string {
		return FieldsConditionRoute::REST_API_ROUTE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_endpoint_option_names(): array {
		return [
			LogicRulesFieldOption::FIELD_NAME,
		];
	}
}
