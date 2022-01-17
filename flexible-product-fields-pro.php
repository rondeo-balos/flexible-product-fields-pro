<?php
/**
	Plugin Name: Flexible Product Fields Pro
	Plugin URI: https://www.wpdesk.net/products/flexible-product-fields-pro-woocommerce/
	Description: Allow customers to customize WooCommerce products before adding them to cart. Add fields: text, dropdown, checkbox, radio and assign fixed or percentage prices.
	Version: 2.1.0
	Author: WP Desk
	Author URI: https://www.wpdesk.net/
	Text Domain: flexible-product-fields-pro
	Domain Path: /lang/
	Requires at least: 5.2
	Tested up to: 5.9
	WC requires at least: 5.7
	WC tested up to: 6.0
	Requires PHP: 7.0

	Copyright 2017 WP Desk Ltd.

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @package Flexible Product Fields PRO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* THIS VARIABLE CAN BE CHANGED AUTOMATICALLY */
$plugin_version = '2.1.0';

/*
 * Compatible version with base version of FPF plugin:
 * - older major version: no compatibility (disables plugin)
 * - older minor version: compatibility problems (displays notice)
 */
$plugin_version_dev = '1.1';

define( 'FLEXIBLE_PRODUCT_FIELDS_PRO_VERSION', $plugin_version );
define( 'FLEXIBLE_PRODUCT_FIELDS_PRO_VERSION_DEV', $plugin_version_dev );

$plugin_name        = 'Flexible Product Fields PRO';
$plugin_class_name  = 'Flexible_Product_Fields_PRO_Plugin';
$plugin_text_domain = 'flexible-product-fields-pro';
$product_id         = 'Flexible Product Fields PRO';
$plugin_file        = __FILE__;
$plugin_dir         = dirname( __FILE__ );

$requirements = [
	'php'          => '7.0',
	'wp'           => '4.9',
	'plugins'      => [
		[
			'name'      => 'woocommerce/woocommerce.php',
			'nice_name' => 'WooCommerce',
		],
	],
	'repo_plugins' => [
		[
			'name'      => 'flexible-product-fields/flexible-product-fields.php',
			'nice_name' => 'Flexible Product Fields',
			'version'   => '1.2.2',
		],
	],
];

require __DIR__ . '/vendor_prefixed/wpdesk/wp-plugin-flow/src/plugin-init-php52.php';
