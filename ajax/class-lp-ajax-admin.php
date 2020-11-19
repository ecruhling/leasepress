<?php
/**
 * LeasePress Admin AJAX
 *
 * @package   LeasePress
 * @author Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link   https://resourceatlanta.com
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
		add_action( 'wp_ajax_lp_create_floor_plans', array( $this, 'lp_create_floor_plans' ) );
	}

	/**
	 * Get RENTCafe data AJAX
	 *
	 * @return void
	 */
	public function get_rentcafe_data_ajax() {
		$method = ( isset( $_POST['method'] ) ) ? sanitize_text_field( wp_unslash( $_POST['method'] ) ) : 0;
		$type   = ( isset( $_POST['type'] ) ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : null;
		$nonce  = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : null;

		if ( wp_verify_nonce( $nonce, 'get_rentcafe_data_ajax' ) ) {
			$return = LP_API_Lookups::get_rentcafe_data( $method, $type );
			wp_send_json_success( $return );
		}

	}

	/**
	 * Delete and regenerate cached RENTCafe data
	 *
	 * @return mixed
	 */
	public function delete_rentcafe_transient() {

		// forget both transients.
		forget_transient( 'lp_rentcafe_floorplan_api_data', null );
		forget_transient( 'lp_rentcafe_apartmentavailability_api_data', null );

		// regenerate both transients.
		LP_Transient::get_or_cache_transient( 'floorplan' );
		LP_Transient::get_or_cache_transient( 'apartmentavailability' );

		return null;
	}

	/**
	 * Create Floor Plans
	 */
	public function lp_create_floor_plans() {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : null;

		if ( wp_verify_nonce( $nonce, 'lp_create_floor_plans_nonce' ) ) {
			$floor_plans_data = LP_API_Lookups::get_rentcafe_data( 'floorplan', null );
			// TODO: check for error code!

			$floor_plans_json = json_decode( $floor_plans_data[1]['body'] );

			foreach ( $floor_plans_json as $floor_plan ) {
				$postarr = array(
					// @codingStandardsIgnoreStart (FloorplanName is the correct name and cannot be changed)
					'post_title'  => $floor_plan->FloorplanName,
					// @codingStandardsIgnoreEnd
					'post_type'   => 'lp-floor-plans',
					'post_status' => 'publish',
					'meta_input'  => '',
				);
				wp_insert_post( $postarr );
				// TODO: create a new post for each floor plan.
				// sample data:
				// "PropertyId": "1254808",
				// "FloorplanId": "3456956",
				// "FloorplanName": "Express",
				// "Beds": "0",
				// "Baths": "1.00",
				// "MinimumSQFT": "496",
				// "MaximumSQFT": "518",
				// "MinimumRent": "1065",
				// "MaximumRent": "1245",
				// "MinimumDeposit": "0",
				// "MaximumDeposit": "0",
				// "AvailableUnitsCount": "30",
				// "AvailabilityURL": "https://the-line-rentcafewebsite.securecafe.com/onlineleasing/the-line/oleapplication.aspx?stepname=Apartments&myOlePropertyId=1254808&floorPlans=3456956",
				// "FloorplanImageURL": "https://cdn.rentcafe.com/dmslivecafe/2/92356/TheLine-0x1-Express_496-518-SF.png",
				// "FloorplanImageName": "TheLine-0x1-Express_496-518-SF.png",
				// "FloorplanImageAltText": "The Line Express",
				// "PropertyShowsSpecials": "0",
				// "FloorplanHasSpecials": "0",
				// "UnitTypeMapping": "S1Line"

			}

			wp_send_json_success( $floor_plans_data );

		}
	}

	/**
	 * Delete Floor Plans
	 */
	public function lp_delete_floor_plans() {
		$floor_plans = get_pages( array( 'post_type' => 'lp-floor-plans' ) );

		foreach ( $floor_plans as $floor_plan ) {
			wp_delete_post( $floor_plan->ID, true );
		}
	}
}
