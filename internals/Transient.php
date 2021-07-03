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

namespace LeasePress\Internals;

use LeasePress\Engine\Base;
use stdClass;
use function is_wp_error;
use function json_decode;
use function remember_transient;
use function wp_remote_retrieve_body;

/**
 * Transient used by the plugin
 */
class Transient extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
	}

	/**
	 * Retrieve or cache data in a WordPress transient
	 *
	 * @param string $method The method name used for the lookup.
	 *
	 * @return object
	 * @since 1.0.0
	 */
	public function get_or_cache_transient( string $method ): object {
		$key    = 'lp_rentcafe_' . $method . '_api_data';
		$expire = lp_get_settings()['lp_cache_time'] ? lp_get_settings()['lp_cache_time'] : HOUR_IN_SECONDS;

		// Use wp-cache-remember package to retrieve or save in transient.
		return remember_transient(
			$key,
			static function () use ( $method, $key ) {
				$response = LP_API_Lookups::get_rentcafe_data( $method )[1];
				if ( is_wp_error( $response ) ) {
					// In case API is down we return an empty object.
					return new stdClass();
				}

				// If everything's okay, parse the body and json_decode it.
				return json_decode( wp_remote_retrieve_body( $response ) );
			},
			$expire
		);
	}

	/**
	 * Print the transient content.
	 *
	 * @param string $method The method name used for the lookup.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function print_transient_output( string $method ) {
		$transient = $this->get_or_cache_transient( $method );
		echo '<div class="siteapi-bridge-container">';

		foreach ( $transient as $value ) {
			echo '<div class="siteapi-bridge-single">';
			// @codingStandardsIgnoreStart (because FloorplanName is in the data, and otherwise PHPCS complains)
			echo '<code>' . esc_html( $value->FloorplanName ) . '</code>';
			// @codingStandardsIgnoreEnd
			echo '</div>';
		}

		echo '</div>';
	}

}

