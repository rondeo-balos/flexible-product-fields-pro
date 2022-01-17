<?php

namespace WPDesk\FPF\Pro\Settings;

use WPDesk\FPF\Free\Settings\Route\RouteIntegration;
use WPDesk\FPF\Pro\Settings\Route\FieldsConditionRoute;
use WPDesk\FPF\Pro\Settings\Route\FieldsFieldRoute;
use WPDesk\FPF\Pro\Settings\Route\FieldsValueRoute;
use WPDesk\FPF\Pro\Settings\Route\ProductsCatsRoute;
use WPDesk\FPF\Pro\Settings\Route\ProductsTagsRoute;

/**
 * Supports management for REST API routes.
 */
class Routes {

	/**
	 * Initializes actions for class.
	 *
	 * @return void
	 */
	public function init() {
		( new RouteIntegration( new FieldsFieldRoute() ) )->hooks();
		( new RouteIntegration( new FieldsConditionRoute() ) )->hooks();
		( new RouteIntegration( new FieldsValueRoute() ) )->hooks();
		( new RouteIntegration( new ProductsCatsRoute() ) )->hooks();
		( new RouteIntegration( new ProductsTagsRoute() ) )->hooks();
	}
}
