<?php

namespace WPDesk\FPF\Pro\Settings\Option;

use WPDesk\FPF\Free\Settings\Option\OptionAbstract;
use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;

/**
 * {@inheritdoc}
 */
class ExcludedDatesOption extends OptionAbstract {

	const FIELD_NAME = 'dates_excluded';

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
		return AdvancedTab::TAB_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return self::FIELD_TYPE_TEXTAREA;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Excluded dates', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_label_tooltip(): string {
		return __( 'Enter specific dates separating them with commas. Use a valid date format, e.g. dd.mm.yyyy or yyyy-mm-dd.', 'flexible-product-fields-pro' );
	}
}
