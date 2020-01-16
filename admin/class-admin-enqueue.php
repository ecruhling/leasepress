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
class L_Admin_Enqueue extends L_Admin_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
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
	 *
	 * @return mixed Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {
		$screen = get_current_screen();
		if ( $screen->id === 'toplevel_page_leasepress' || strpos( $_SERVER[ 'REQUEST_URI' ], 'index.php' ) || strpos( $_SERVER[ 'REQUEST_URI' ], get_bloginfo( 'wpurl' ) . '/wp-admin/' ) ) {
			wp_enqueue_style( L_TEXTDOMAIN . '-settings-styles', plugins_url( 'assets/css/settings.css', L_PLUGIN_ABSOLUTE ), array( 'dashicons' ), L_VERSION );
		}

		wp_enqueue_style( L_TEXTDOMAIN . '-admin-styles', plugins_url( 'assets/css/admin.css', L_PLUGIN_ABSOLUTE ), array( 'dashicons' ), L_VERSION );
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {
		$screen = get_current_screen();
        if ( $screen->id === 'toplevel_page_leasepress' ) {
            wp_enqueue_script( L_TEXTDOMAIN . '-settings-script', plugins_url( 'assets/js/settings.js', L_PLUGIN_ABSOLUTE ), array( 'jquery', 'jquery-ui-tabs' ), L_VERSION );
        }

		wp_enqueue_script( L_TEXTDOMAIN . '-admin-script', plugins_url( 'assets/js/admin.js', L_PLUGIN_ABSOLUTE ), array( 'jquery' ), L_VERSION );
	}

}
