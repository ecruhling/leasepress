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
 * This class contain the Enqueue stuff for the frontend
 */
class LP_Enqueue extends LP_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
		parent::initialize();

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_js_vars' ) );
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function enqueue_styles() {
		wp_enqueue_style( 'leasepress-plugin-styles', plugins_url( 'dist/styles/public.css', LP_PLUGIN_ABSOLUTE ), array(), LP_VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function enqueue_scripts() {
		$settings = lp_get_settings();
		$template = array_key_exists( 'lp_page_template', $settings ) ? $settings['lp_page_template'] : null;
		if ( is_page_template( $template ) ) {
			wp_enqueue_script( 'leasepress-plugin-script', plugins_url( 'dist/scripts/public.js', LP_PLUGIN_ABSOLUTE ), array( 'jquery' ), LP_VERSION, true );
		}
	}

	/**
	 * Print the PHP var in the HTML of the frontend for access by JavaScript
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function enqueue_js_vars() {
		$settings = lp_get_settings();
		$template = array_key_exists( 'lp_page_template', $settings ) ? $settings['lp_page_template'] : null;
		if ( is_page_template( $template ) ) {
			wp_localize_script(
				'leasepress-plugin-script',
				'ls_js_vars',
				array(
					'alert'    => __( 'LeasePress public.js enqueued and running', 'leasepress' ),
					'template' => $template,
				)
			);
		}
	}

}
