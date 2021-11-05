<?php

namespace WPDesk\FPF\Pro\Field\Type;

use WPDesk\FPF\Free\Field\Type\HeadingType as DefaultHeadingType;
use WPDesk\FPF\Free\Settings\Option\CssOption;
use WPDesk\FPF\Free\Settings\Option\FieldLabelOption;
use WPDesk\FPF\Free\Settings\Option\FieldNameOption;
use WPDesk\FPF\Free\Settings\Option\FieldPriorityOption;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FPF\Free\Settings\Tab\GeneralTab;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;
use WPDesk\FPF\Pro\Settings\Option\LogicEnabledOption;
use WPDesk\FPF\Pro\Settings\Option\LogicOperatorOption;
use WPDesk\FPF\Pro\Settings\Option\LogicRulesOption;

/**
 * .
 */
class HeadingType extends DefaultHeadingType {

	/**
	 * {@inheritdoc}
	 */
	public function get_options_objects(): array {
		return [
			GeneralTab::TAB_NAME => [
				FieldPriorityOption::FIELD_NAME => new FieldPriorityOption(),
				FieldTypeOption::FIELD_NAME     => new FieldTypeOption(),
				FieldLabelOption::FIELD_NAME    => new FieldLabelOption(),
				CssOption::FIELD_NAME           => new CssOption(),
				FieldNameOption::FIELD_NAME     => new FieldNameOption(),
			],
			LogicTab::TAB_NAME   => [
				LogicEnabledOption::FIELD_NAME  => new LogicEnabledOption(),
				LogicOperatorOption::FIELD_NAME => new LogicOperatorOption(),
				LogicRulesOption::FIELD_NAME    => new LogicRulesOption(),
			],
		];
	}
}
