<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;

/**
 * {@inheritdoc}
 */
class LogicRulesOption extends OptionAbstract {

	const FIELD_NAME = 'logic_rules';

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
		return self::FIELD_TYPE_REPEATER;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_row_label(): string {
		/* translators: %s: rule index */
		return __( 'Rule #%s', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_regexes_to_display(): array {
		return [
			LogicEnabledOption::FIELD_NAME => '^1$',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return [
			[
				LogicRulesFieldOption::FIELD_NAME     => '',
				LogicRulesConditionOption::FIELD_NAME => '',
				LogicRulesValueOption::FIELD_NAME     => '',
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_children(): array {
		return [
			LogicRulesFieldOption::FIELD_NAME     => new LogicRulesFieldOption(),
			LogicRulesConditionOption::FIELD_NAME => new LogicRulesConditionOption(),
			LogicRulesValueOption::FIELD_NAME     => new LogicRulesValueOption(),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_refresh_trigger(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function sanitize_option_value( $field_value ) {
		if ( ! $field_value ) {
			return [];
		}

		foreach ( $field_value as $row_index => $row ) {
			if ( $row[ LogicRulesConditionOption::FIELD_NAME ] === '' ) {
				$field_value[ $row_index ][ LogicRulesConditionOption::FIELD_NAME ] = 'is';
			}
		}
		return $field_value;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save_field_data( array $field_data, array $field_settings ): array {
		if ( intval( $field_settings[ LogicEnabledOption::FIELD_NAME ] ?? 0 ) !== 1 ) {
			return $field_data;
		}

		return $this->update_field_data( $field_data, $field_settings );
	}
}
