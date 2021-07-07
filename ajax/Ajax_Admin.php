<?php
/**
 * LeasePress
 *
 * @package   LeasePress
 * @author Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link   https://resourceatlanta.com
 */

namespace LeasePress\Ajax;

use LeasePress\Engine\Base;
use LeasePress\Integrations\RentCafe;
use LeasePress\Internals\Transient;
use function apply_filters;

/**
 * AJAX for logged-in users
 */
class Ajax_Admin extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! apply_filters( 'leasepress_lp_ajax_admin_initialize', true ) ) {
			return;
		}

		// For logged in users.
		add_action( 'wp_ajax_lp_delete_rentcafe_transient', array( $this, 'lp_delete_rentcafe_transient' ) );
		add_action( 'wp_ajax_lp_get_rentcafe_data', array( $this, 'lp_get_rentcafe_data' ) );
		add_action( 'wp_ajax_lp_create_floor_plans', array( $this, 'lp_create_floor_plans' ) );
		add_action( 'wp_ajax_lp_delete_floor_plans', array( $this, 'lp_delete_floor_plans' ) );
	}

	/**
	 * Get RENTCafe data via AJAX
	 *
	 * @return void
	 */
	public function lp_get_rentcafe_data() {
		$method = ( isset( $_POST['method'] ) ) ? sanitize_text_field( wp_unslash( $_POST['method'] ) ) : 0;
		$type   = ( isset( $_POST['type'] ) ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : null;
		$nonce  = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : null;

		if ( wp_verify_nonce( $nonce, 'get_rentcafe_data_ajax' ) ) {
			$return = RentCafe::get_rentcafe_data( $method, $type );
			wp_send_json_success( $return );
		}

	}

	/**
	 * Delete and regenerate cached RENTCafe data
	 *
	 * @return void
	 */
	public function lp_delete_rentcafe_transient() {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : null;

		if ( wp_verify_nonce( $nonce, 'lp_api_clear_cache_nonce' ) ) {

			// forget both transients.
			forget_transient( 'lp_rentcafe_floorplan_api_data' );
			forget_transient( 'lp_rentcafe_apartmentavailability_api_data' );

			// regenerate both transients.
			( new Transient() )->get_or_cache_transient( 'floorplan' );
			( new Transient() )->get_or_cache_transient( 'apartmentavailability' );
		}
	}

	/**
	 * Create Floor Plans
	 *
	 * Using the data coming from RENTCafe, create a floor plan CPT
	 * for each floor plan.
	 */
	public function lp_create_floor_plans() {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : null;

		if ( wp_verify_nonce( $nonce, 'lp_create_floor_plans_nonce' ) ) {
			$floor_plans_data = RentCafe::get_rentcafe_data( 'floorplan', null );
			// TODO: check for error code!

			$floor_plans = json_decode( $floor_plans_data[1]['body'] );

			foreach ( $floor_plans as $floor_plan ) {
				$postarr = array(
					'post_type'   => 'lp-floor-plans',
					'post_status' => 'publish',
					// @codingStandardsIgnoreStart (The following are the correct attribute names and cannot be changed)
					'post_title'  => $floor_plan->FloorplanName,
					'meta_input'  => array(
						'lp_unit_type_mapping' => $floor_plan->UnitTypeMapping,
						'lp_beds'              => $floor_plan->Beds,
						'lp_baths'             => $floor_plan->Baths,
						// @codingStandardsIgnoreEnd
					),
				);
				wp_insert_post( $postarr );

				// TODO: create a new post for each floor plan.

			}

			wp_send_json_success( count( $floor_plans ) );

		}
	}

	/**
	 * Delete Floor Plans
	 *
	 * Completely deletes all the Floor Plans CPT posts.
	 */
	public function lp_delete_floor_plans() {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : null;

		if ( wp_verify_nonce( $nonce, 'lp_delete_floor_plans_nonce' ) ) {
			$floor_plans = get_pages( array( 'post_type' => 'lp-floor-plans' ) );

			foreach ( $floor_plans as $floor_plan ) {
				wp_delete_post( $floor_plan->ID, true );
			}

			wp_send_json_success( count( $floor_plans ) );

		}
	}
}
