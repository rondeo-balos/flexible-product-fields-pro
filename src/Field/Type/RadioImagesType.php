<?php

namespace WPDesk\FPF\Pro\Field\Type;

use WPDesk\FPF\Free\Field\Type\RadioImagesType as DefaultRadioImagesType;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;
use WPDesk\FPF\Free\Settings\Tab\PricingTab;
use WPDesk\FPF\Pro\Settings\Option\LogicEnabledOption;
use WPDesk\FPF\Pro\Settings\Option\LogicOperatorOption;
use WPDesk\FPF\Pro\Settings\Option\LogicRulesOption;
use WPDesk\FPF\Pro\Settings\Option\PriceValuesOption;

/**
 * .
 */
class RadioImagesType extends DefaultRadioImagesType {

	/**
	 * {@inheritdoc}
	 */
	public function get_options_objects(): array {
		return array_merge(
			parent::get_options_objects(),
			[
				PricingTab::TAB_NAME => [
					PriceValuesOption::FIELD_NAME => new PriceValuesOption(),
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
