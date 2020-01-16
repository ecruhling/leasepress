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
class L_Enqueue extends L_Base {

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
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function enqueue_styles() {
		wp_enqueue_style( L_TEXTDOMAIN . '-plugin-styles', plugins_url( 'assets/css/public.css', L_PLUGIN_ABSOLUTE ), array(), L_VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function enqueue_scripts() {
		wp_enqueue_script( L_TEXTDOMAIN . '-plugin-script', plugins_url( 'assets/js/public.js', L_PLUGIN_ABSOLUTE ), array( 'jquery' ), L_VERSION );
	}

	/**
	 * Print the PHP var in the HTML of the frontend for access by JavaScript
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function enqueue_js_vars() {
		wp_localize_script(
             L_TEXTDOMAIN . '-plugin-script', 'l_js_vars', array(
			'alert' => __( 'Hey! You have clicked the button!', L_TEXTDOMAIN ),
		)
		);
	}

}
