<?php

/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   LeasePress
 * @author	  Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link	  https://resourceatlanta.com
 *
 * Plugin Name:	    LeasePress
 * Description:	    Ready to graduate from renting to leasing? Supports API data from Entrata & RENTCafe.
 * Version:		    1.0.0
 * Author:			Resource Branding and Design
 * Author URI:		https://resourceatlanta.com
 * Text Domain:	    leasepress
 * License:		    GPL 2.0+
 * License URI:	    http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:	    /languages
 * Requires PHP:	7.0
 * WordPress-Plugin-Boilerplate-Powered: v3.1.3
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
	die;
}

define( 'LP_VERSION', '1.0.0' );
define( 'LP_TEXTDOMAIN', 'leasepress' );
define( 'LP_NAME', 'LeasePress' );
define( 'LP_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
define( 'LP_PLUGIN_ABSOLUTE', __FILE__ );

/**
 * Load the textdomain of the plugin
 *
 * @return void
 */
function lp_load_plugin_textdomain() {
	$locale = apply_filters( 'plugin_locale', get_locale(), LP_TEXTDOMAIN );
	load_textdomain( LP_TEXTDOMAIN, trailingslashit( WP_PLUGIN_DIR ) . LP_TEXTDOMAIN . '/languages/' . LP_TEXTDOMAIN . '-' . $locale . '.mo' );
}

add_action( 'plugins_loaded', 'lp_load_plugin_textdomain', 1 );
if ( version_compare( PHP_VERSION, '7.1.3', '<' ) ) {
	function l_deactivate() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	function l_show_deactivation_notice() {
		echo wp_kses_post(
			sprintf(
				'<div class="notice notice-error"><p>%s</p></div>',
				__( '"LeasePress" requires PHP 7.1.3 or newer.', LP_TEXTDOMAIN )
			)
		);
	}

	add_action( 'admin_init', 'lp_deactivate' );
	add_action( 'admin_notices', 'lp_show_deactivation_notice' );

	// Return early to prevent loading the other includes.
	return;
}

require_once( LP_PLUGIN_ROOT . 'vendor/autoload.php' );

require_once( LP_PLUGIN_ROOT . 'internals/functions.php' );
require_once( LP_PLUGIN_ROOT . 'internals/debug.php' );

/**
 * Create a helper function for easy SDK access.
 *
 * @global type $lp_fs
 * @return object
 */
function lp_fs() {
	global $lp_fs;

	if ( !isset( $lp_fs ) ) {
		require_once( LP_PLUGIN_ROOT . 'vendor/freemius/wordpress-sdk/start.php' );
		$lp_fs = fs_dynamic_init(
			array(
				'id'			 => '',
				'slug'			 => 'leasepress',
				'public_key'	 => '',
				'is_live'		 => false,
				'is_premium'	 => true,
				'has_addons'	 => false,
				'has_paid_plans' => true,
				'menu'			 => array(
					'slug' => 'leasepress',
				),
			)
		);


		if ( $lp_fs->is_premium() ) {
			$lp_fs->add_filter( 'support_forum_url', 'gt_premium_support_forum_url' );

			function gt_premium_support_forum_url( $wp_org_support_forum_url ) {
				return 'http://your url';
			}
		}
	}

	return $lp_fs;
}

// Init Freemius.
// lp_fs();

if ( ! wp_installing() ) {
	add_action( 'plugins_loaded', array( 'LP_Initialize', 'get_instance' ) );
}
