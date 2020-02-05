<?php

/**
 * Plugin name
 *
 * @package   LeasePress
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 */

/**
 * Transient class
 */
class LP_Transient extends LP_Base {

	/**
	 * Initialize the snippet
	 */
	public function initialize() {
		parent::initialize();
	}

	/**
	 * Retrieve or cache data in a WordPress transient
	 *
	 * @param $method
	 *
	 * @return mixed
	 */
	public function get_or_cache_transient( $method ) {
		$key = 'lp_rentcafe_floorplans_api_data';

		return remember_transient(
			$key, function () use ( $method, $key ) {
			$response = ( new LP_API_Lookups )->get_rentcafe_data( $method );
			if ( is_wp_error( $response ) ) {
				return false;
			}

			return json_decode( wp_remote_retrieve_body( $response ) );
		}, HOUR_IN_SECONDS
		);
	}

	/**
	 * Print the transient content
	 *
	 * @param $method
	 *
	 * @return void
	 */
	public function print_transient_output( $method ) {
		$transient = $this->get_or_cache_transient( $method );
		echo '<div class="siteapi-bridge-container">';
		foreach ( $transient as &$value ) {
			echo '<div class="siteapi-bridge-single">';
			echo $value->FloorplanName;
			echo '</div>';
		}

		echo '</div>';
	}

}

