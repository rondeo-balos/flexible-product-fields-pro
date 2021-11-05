<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionsImageOption;
use WPDesk\FPF\Free\Settings\Option\OptionsLabelOption;
use WPDesk\FPF\Free\Settings\Option\OptionsValueOption;

/**
 * {@inheritdoc}
 */
class OptionsWithImageOption extends OptionsOption {

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return [
			[
				OptionsValueOption::FIELD_NAME => '',
				OptionsLabelOption::FIELD_NAME => '',
				OptionsImageOption::FIELD_NAME => '',
				PriceTypeOption::FIELD_NAME    => '',
				PriceValueOption::FIELD_NAME   => '',
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_children(): array {
		return [
			OptionsValueOption::FIELD_NAME => new OptionsValueOption(),
			OptionsLabelOption::FIELD_NAME => new OptionsLabelOption(),
			OptionsImageOption::FIELD_NAME => new OptionsImageOption(),
			PriceTypeOption::FIELD_NAME    => new PriceTypeOption(),
			PriceValueOption::FIELD_NAME   => new PriceValueOption(),
		];
	}
}
