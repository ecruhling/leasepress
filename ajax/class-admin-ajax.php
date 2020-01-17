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
 * AJAX in the admin
 */
class LP_Ajax_Admin extends LP_Admin_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
		if ( !apply_filters( 'leasepress_lp_ajax_admin_initialize', true ) ) {
			return;
		}

		// For logged user
		add_action( 'wp_ajax_your_admin_method', array( $this, 'your_admin_method' ) );
	}

	/**
	 * The method to run on ajax
	 *
	 * @return void
	 */
	public function your_admin_method() {
		$return = array(
			'message' => 'Saved',
			'ID'      => 2,
		);

		wp_send_json_success( $return );
		// wp_send_json_error( $return );
	}

}

