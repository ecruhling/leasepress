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
	public static function get_or_cache_transient( $method ) {
		$key    = 'lp_rentcafe_' . $method . '_api_data';
		$expire = lp_get_settings()['lp_cache_time'] ? lp_get_settings()['lp_cache_time'] : HOUR_IN_SECONDS;

		return remember_transient(
			$key, function () use ( $method, $key ) {
			$response = \LP_API_Lookups::get_rentcafe_data( $method )[1];
			if ( is_wp_error( $response ) ) {
				return false;
			}

			return json_decode( wp_remote_retrieve_body( $response ) );
		}, $expire );
	}

	/**
	 * Print the transient content
	 *
	 * @param $method
	 *
	 * @return void
	 */
	public static function print_transient_output( $method ) {
		$transient = self::get_or_cache_transient( $method );
		echo '<div class="siteapi-bridge-container">';

		foreach ( $transient as &$value ) {
			echo '<div class="siteapi-bridge-single">';
			echo '<code>' . $value->FloorplanName . '</code>';
			echo '</div>';
		}

		echo '</div>';
	}

}

