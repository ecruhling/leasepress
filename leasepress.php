<?php
/**
 * LeasePress
 *
 * @package     LeasePress
 * @author      Erik Ruhling <ecruhling@gmail.com>
 * @copyright   Resource Branding and Design
 * @license     GPL 2.0+
 * @link        https://resourceatlanta.com
 *
 * @wordpress-plugin
 * Plugin Name:       LeasePress
 * Description:       Supports API data from RENTCafe.
 * Version:           1.0.0
 * Author:            Resource Branding and Design
 * Author URI:        https://resourceatlanta.com
 * Text Domain:       leasepress
 * Domain Path:       /languages
 * Requires PHP:      7.1.3
 * Based On:          WordPress Plugin Boilerplate Powered 3.1.3    https://github.com/WPBP/WordPress-Plugin-Boilerplate-Powered
 */

use LeasePress\Engine\Initialize;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Sorry, but you can not directly access this file.' );
}

const LP_VERSION         = '1.0.0';
const LP_TEXTDOMAIN      = 'leasepress';
const LP_NAME            = 'leasepress';
const LP_PLUGIN_ABSOLUTE = __FILE__;
const LP_MIN_PHP_VERSION = 7.1;
const LP_WP_VERSION      = 5.3;
define( 'LP_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );

/**
 * Load the textdomain of the plugin
 *
 * @return void
 */
add_action(
	'init',
	static function () {
		load_plugin_textdomain( LP_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
);

/**
 * Verify minimum PHP version
 */
if ( version_compare( PHP_VERSION, LP_MIN_PHP_VERSION, '<=' ) ) {
	add_action(
		'admin_init',
		static function () {
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
	);
	add_action(
		'admin_notices',
		static function () {
			echo wp_kses_post(
				sprintf(
					'<div class="notice notice-error"><p>%s</p></div>',
					__( 'LeasePress requires PHP 7.1.3 or newer.', 'leasepress' )
				)
			);
		}
	);

	// Return early to prevent loading the plugin.
	return;
}

$leasepress_libraries = require_once LP_PLUGIN_ROOT . 'vendor/autoload.php';

require_once LP_PLUGIN_ROOT . 'internals/functions.php';
require_once LP_PLUGIN_ROOT . 'internals/debug.php';

if ( ! wp_installing() ) {
	add_action(
		'plugins_loaded',
		static function () use ( $leasepress_libraries ) {
			try {
				new Initialize( $leasepress_libraries );
			} catch ( Exception $e ) {
				wp_die( 'initializing the LeasePress plugin has failed.' );
			}
		}
	);
}
