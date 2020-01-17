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
 * This class contain the transient example
 */
class LP_Transient extends LP_Base {

	/**
	 * Initialize the snippet
	 */
	public function initialize() {
		parent::initialize();
	}

	/**
	 * This method contains an example of caching a transient with an external request.
	 *
	 * @return object
	 */
	public function transient_caching_example() {
		$key = 'lp_rentcafe_floorplans';

		// Use wp-cache-remember package to retrieve or save in transient
		return remember_transient(
             $key, function () use ( $key ) {
				// If there's no cached version we ask
				$response = ( new LP_API_Lookups )->floorplanTypes();
			if ( is_wp_error( $response ) ) {
					// In case API is down we return the last successful count
					return;
				}

				// If everything's okay, parse the body and json_decode it
//				return json_decode( wp_remote_retrieve_body( $response ) );
	             // @TODO revert this to undecoded json so that is_wp_error above works correctly
				return $response;
			 }, HOUR_IN_SECONDS
            );
	}

	/**
	 * Print the transient content
	 *
	 * @return void
	 */
	public function print_transient_output() {
		$transient = $this->transient_caching_example();
		echo '<div class="siteapi-bridge-container">';
		foreach ( $transient as &$value ) {
			echo '<div class="siteapi-bridge-single">';
			echo $value->FloorplanName;
			echo '</div>';
		}

		echo '</div>';
	}

}

