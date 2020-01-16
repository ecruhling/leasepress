<?php

/**
 * Plugin_name
 *
 * @package   Plugin_name
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 */

/**
 * AJAX in the public
 */
class L_Ajax extends L_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
		if ( !apply_filters( 'leasepress_l_ajax_initialize', true ) ) {
			return;
		}

		// For not logged user
		add_action( 'wp_ajax_nopriv_your_method', array( $this, 'your_method' ) );
	}

	/**
	 * The method to run on ajax
	 *
	 * @return void
	 */
	public function your_method() {
		$return = array(
			'message' => 'Saved',
			'ID'      => 1,
		);

		wp_send_json_success( $return );
		// wp_send_json_error( $return );
	}

}

