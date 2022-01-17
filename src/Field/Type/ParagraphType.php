<?php

namespace WPDesk\FPF\Pro\Field\Type;

use WPDesk\FPF\Free\Field\Type\ParagraphType as DefaultParagraphType;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;
use WPDesk\FPF\Pro\Settings\Option\LogicEnabledOption;
use WPDesk\FPF\Pro\Settings\Option\LogicOperatorOption;
use WPDesk\FPF\Pro\Settings\Option\LogicRulesOption;

/**
 * .
 */
class ParagraphType extends DefaultParagraphType {

	/**
	 * {@inheritdoc}
	 */
	public function get_options_objects(): array {
		return array_merge(
			parent::get_options_objects(),
			[
				LogicTab::TAB_NAME => [
					LogicEnabledOption::FIELD_NAME  => new LogicEnabledOption(),
					LogicOperatorOption::FIELD_NAME => new LogicOperatorOption(),
					LogicRulesOption::FIELD_NAME    => new LogicRulesOption(),
				],
			]
		);
	}
}
