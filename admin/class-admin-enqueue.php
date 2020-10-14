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

/**
 * This class contain the Enqueue stuff for the backend
 */
class LP_Admin_Enqueue extends LP_Admin_Base {

	/**
	 * Initialize the class
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
	 * @return mixed Return early if no settings page is registered.
	 * @since 1.0.0
	 */
	public function enqueue_admin_styles() {
		$screen = get_current_screen();
		if ( 'toplevel_page_leasepress' === $screen->id ) {
			wp_enqueue_style( 'leasepress-settings-styles', plugins_url( 'assets/css/settings.css', LP_PLUGIN_ABSOLUTE ), array( 'dashicons' ), LP_VERSION );
		}

		wp_enqueue_style( 'leasepress-admin-styles', plugins_url( 'assets/css/admin.css', LP_PLUGIN_ABSOLUTE ), array( 'dashicons' ), LP_VERSION );

		return null;
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @return mixed Return early if no settings page is registered.
	 * @since 1.0.0
	 */
	public function enqueue_admin_scripts() {
		$screen = get_current_screen();
		if ( 'toplevel_page_leasepress' === $screen->id ) {
			wp_enqueue_script(
				'leasepress-settings-script',
				plugins_url(
					'assets/js/settings.js',
					LP_PLUGIN_ABSOLUTE
				),
				array(
					'jquery',
					'jquery-ui-tabs',
				),
				LP_VERSION,
				true,
			);
		}

		wp_enqueue_script(
			'leasepress-admin-script',
			plugins_url(
				'assets/js/admin.js',
				LP_PLUGIN_ABSOLUTE
			),
			array(
				'jquery',
			),
			LP_VERSION,
			true,
		);

		return null;
	}

}
