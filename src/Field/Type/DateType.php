<?php

namespace WPDesk\FPF\Pro\Field\Type;

use WPDesk\FPF\Free\Field\Type\DateType as DefaultDateType;
use WPDesk\FPF\Free\Settings\Option\CssOption;
use WPDesk\FPF\Free\Settings\Option\FieldLabelOption;
use WPDesk\FPF\Free\Settings\Option\FieldNameOption;
use WPDesk\FPF\Free\Settings\Option\FieldPriorityOption;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FPF\Free\Settings\Option\PlaceholderOption;
use WPDesk\FPF\Free\Settings\Option\RequiredOption;
use WPDesk\FPF\Free\Settings\Option\TooltipOption;
use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;
use WPDesk\FPF\Free\Settings\Tab\GeneralTab;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;
use WPDesk\FPF\Free\Settings\Tab\PricingTab;
use WPDesk\FPF\Pro\Settings\Option\DateFormatOption;
use WPDesk\FPF\Pro\Settings\Option\DaysAfterOption;
use WPDesk\FPF\Pro\Settings\Option\DaysBeforeOption;
use WPDesk\FPF\Pro\Settings\Option\ExcludedDatesOption;
use WPDesk\FPF\Pro\Settings\Option\ExcludedWeekDaysOption;
use WPDesk\FPF\Pro\Settings\Option\FirstWeekDayOption;
use WPDesk\FPF\Pro\Settings\Option\LogicEnabledOption;
use WPDesk\FPF\Pro\Settings\Option\LogicOperatorOption;
use WPDesk\FPF\Pro\Settings\Option\LogicRulesOption;
use WPDesk\FPF\Pro\Settings\Option\PriceTypeOption;
use WPDesk\FPF\Pro\Settings\Option\PriceValueOption;
use WPDesk\FPF\Pro\Settings\Option\SelectedDatesLimitOption;
use WPDesk\FPF\Pro\Settings\Option\TodayMaxHourOption;

/**
 * .
 */
class DateType extends DefaultDateType {

	/**
	 * {@inheritdoc}
	 */
	public function get_options_objects(): array {
		return [
			GeneralTab::TAB_NAME  => [
				FieldPriorityOption::FIELD_NAME => new FieldPriorityOption(),
				FieldTypeOption::FIELD_NAME     => new FieldTypeOption(),
				FieldLabelOption::FIELD_NAME    => new FieldLabelOption(),
				RequiredOption::FIELD_NAME      => new RequiredOption(),
				PlaceholderOption::FIELD_NAME   => new PlaceholderOption(),
				CssOption::FIELD_NAME           => new CssOption(),
				TooltipOption::FIELD_NAME       => new TooltipOption(),
				FieldNameOption::FIELD_NAME     => new FieldNameOption(),
			],
			AdvancedTab::TAB_NAME => [
				DateFormatOption::FIELD_NAME         => new DateFormatOption(),
				DaysBeforeOption::FIELD_NAME         => new DaysBeforeOption(),
				DaysAfterOption::FIELD_NAME          => new DaysAfterOption(),
				ExcludedDatesOption::FIELD_NAME      => new ExcludedDatesOption(),
				ExcludedWeekDaysOption::FIELD_NAME   => new ExcludedWeekDaysOption(),
				FirstWeekDayOption::FIELD_NAME       => new FirstWeekDayOption(),
				SelectedDatesLimitOption::FIELD_NAME => new SelectedDatesLimitOption(),
				TodayMaxHourOption::FIELD_NAME       => new TodayMaxHourOption(),
			],
			PricingTab::TAB_NAME  => [
				PriceTypeOption::FIELD_NAME  => new PriceTypeOption(),
				PriceValueOption::FIELD_NAME => new PriceValueOption(),
			],
			LogicTab::TAB_NAME    => [
				LogicEnabledOption::FIELD_NAME  => new LogicEnabledOption(),
				LogicOperatorOption::FIELD_NAME => new LogicOperatorOption(),
				LogicRulesOption::FIELD_NAME    => new LogicRulesOption(),
			],
		];
	}
}
