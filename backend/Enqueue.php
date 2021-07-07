<?php
/**
 * LeasePress
 *
 * @package   LeasePress
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 */

namespace LeasePress\Backend;

use LeasePress\Engine\Base;
use function add_action;
use function get_current_screen;
use function is_null;
use function plugins_url;
use function wp_enqueue_script;
use function wp_enqueue_style;

/**
 * This class contain the Enqueue stuff for the backend
 */
class Enqueue extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}


	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_admin_styles() {
		$admin_page = get_current_screen();

		if ( ! is_null( $admin_page ) && 'toplevel_page_leasepress' === $admin_page->id ) {
			wp_enqueue_style(
				'leasepress-settings-styles',
				plugins_url(
					'dist/styles/settings.css',
					LP_PLUGIN_ABSOLUTE,
				),
				array(
					'dashicons',
				),
				LP_VERSION,
			);
		}

		wp_enqueue_style(
			'leasepress-admin-style',
			plugins_url(
				'dist/styles/admin.css',
				LP_PLUGIN_ABSOLUTE,
			),
			array(
				'dashicons',
			),
			LP_VERSION,
		);
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_admin_scripts() {
		$admin_page = get_current_screen();

		if ( ! is_null( $admin_page ) && 'toplevel_page_leasepress' === $admin_page->id ) {
			wp_enqueue_script(
				'leasepress-settings-script',
				plugins_url(
					'dist/scripts/settings.js',
					LP_PLUGIN_ABSOLUTE,
				),
				array(
					'jquery',
					'jquery-ui-tabs',
				),
				LP_VERSION,
				false
			);
		}

		wp_enqueue_script(
			'leasepress-admin-script',
			plugins_url(
				'dist/scripts/admin.js',
				LP_PLUGIN_ABSOLUTE,
			),
			array(
				'jquery',
			),
			LP_VERSION,
			false
		);
	}

}
