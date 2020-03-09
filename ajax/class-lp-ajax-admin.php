<?php
/**
 * LeasePress Admin AJAX
 *
 * @package   LeasePress
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 */

/**
 * AJAX on the backend
 */
class LP_Ajax_Admin extends LP_Admin_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
		if ( ! apply_filters( 'leasepress_lp_ajax_admin_initialize', true ) ) {
			return;
		}

		// For logged in user.
		add_action( 'wp_ajax_delete_rentcafe_transient', array( $this, 'delete_rentcafe_transient' ) );
		add_action( 'wp_ajax_get_rentcafe_data_ajax', array( $this, 'get_rentcafe_data_ajax' ) );
	}

	/**
	 * Get RENTCafe data AJAX
	 *
	 * @return void
	 */
	public function get_rentcafe_data_ajax() {
		$method = ( isset( $_POST['method'] ) ) ? $_POST['method'] : 0;
		$type   = ( isset( $_POST['type'] ) ) ? $_POST['type'] : null;

		$return = \LP_API_Lookups::get_rentcafe_data( $method, $type );

		wp_send_json_success( $return );
	}

	/**
	 * Delete cached RENTCafe data in a WordPress transient
	 *
	 * @return mixed
	 */
	public function delete_rentcafe_transient() {

		// forget both transients.
		forget_transient( 'lp_rentcafe_floorplan_api_data', null );
		forget_transient( 'lp_rentcafe_apartmentavailability_api_data', null );

		// regenerate both transients.
		\LP_Transient::get_or_cache_transient( 'floorplan' );
		\LP_Transient::get_or_cache_transient( 'apartmentavailability' );

		return null;
	}

}
