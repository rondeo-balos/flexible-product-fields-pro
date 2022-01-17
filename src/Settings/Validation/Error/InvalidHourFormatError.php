<?php

namespace WPDesk\FPF\Pro\Settings\Validation\Error;

use WPDesk\FPF\Free\Settings\Validation\Error\ValidationError;

/**
 * {@inheritdoc}
 */
class InvalidHourFormatError implements ValidationError {

	/**
	 * {@inheritdoc}
	 */
	public function get_message(): string {
		return __( 'Invalid hour format.', 'flexible-product-fields-pro' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_fatal_error(): bool {
		return true;
	}
}
