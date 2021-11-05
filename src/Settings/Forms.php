<?php

namespace WPDesk\FPF\Pro\Settings;

use WPDesk\FPF\Free\Settings\Form\FormIntegration;
use WPDesk\FPF\Pro\Settings\Form\GroupSettingsForm;

/**
 * Supports management for forms.
 */
class Forms {

	/**
	 * Initializes actions for class.
	 *
	 * @return void
	 */
	public function init() {
		( new FormIntegration( new GroupSettingsForm() ) )->hooks();
	}
}
