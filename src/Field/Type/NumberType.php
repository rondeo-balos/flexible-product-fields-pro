<?php

namespace WPDesk\FPF\Pro\Field\Type;

use WPDesk\FPF\Free\Field\Type\NumberType as DefaultNumberType;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;
use WPDesk\FPF\Free\Settings\Tab\PricingTab;
use WPDesk\FPF\Pro\Settings\Option\LogicEnabledOption;
use WPDesk\FPF\Pro\Settings\Option\LogicOperatorOption;
use WPDesk\FPF\Pro\Settings\Option\LogicRulesOption;
use WPDesk\FPF\Pro\Settings\Option\PriceTypeOption;
use WPDesk\FPF\Pro\Settings\Option\PriceValueOption;

/**
 * .
 */
class NumberType extends DefaultNumberType {

	/**
	 * {@inheritdoc}
	 */
	public function get_options_objects(): array {
		return array_merge(
			parent::get_options_objects(),
			[
				PricingTab::TAB_NAME => [
					PriceTypeOption::FIELD_NAME  => new PriceTypeOption(),
					PriceValueOption::FIELD_NAME => new PriceValueOption(),
				],
				LogicTab::TAB_NAME   => [
					LogicEnabledOption::FIELD_NAME  => new LogicEnabledOption(),
					LogicOperatorOption::FIELD_NAME => new LogicOperatorOption(),
					LogicRulesOption::FIELD_NAME    => new LogicRulesOption(),
				],
			]
		);
	}
}
