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

namespace LeasePress\Engine;

use WP_Rewrite;
use WP_User;
use function _doing_it_wrong;
use function add_query_arg;
use function defined;
use function esc_html;
use function function_exists;
use function is_admin;
use function is_amp_endpoint;
use function is_multisite;
use function is_null;
use function is_user_logged_in;
use function rest_url;
use function sprintf;
use function strlen;
use function strpos;
use function substr;
use function trailingslashit;
use function user_can;
use function wp_doing_ajax;
use function wp_doing_cron;
use function wp_get_current_user;
use function wp_parse_url;

/**
 * LeasePress Is Methods
 */
class Is_Methods {

	/**
	 * What type of request is this?
	 *
	 * @param string $type admin, ajax, cron, cli, amp or frontend.
	 *
	 * @return bool
	 * @since  1.0.0
	 */
	public function request( string $type ): bool {
		switch ( $type ) {
			case 'backend':
				return $this->is_admin_backend();

			case 'ajax':
				return $this->is_ajax();

			case 'installing_wp':
				return $this->is_installing_wp();

			case 'rest':
				return $this->is_rest();

			case 'cron':
				return $this->is_cron();

			case 'frontend':
				return $this->is_frontend();

			case 'cli':
				return $this->is_cli();

			case 'amp':
				return $this->is_amp();

			default:
				_doing_it_wrong( __METHOD__, esc_html( sprintf( 'Unknown request type: %s', $type ) ), '1.0.0' );

				return false;
		}
	}

	/**
	 * Is installing WP
	 *
	 * @return bool
	 */
	public function is_installing_wp(): bool {
		return defined( 'WP_INSTALLING' );
	}

	/**
	 * Is admin
	 *
	 * @return bool
	 */
	public function is_admin_backend(): bool {
		return is_user_logged_in() && is_admin();
	}

	/**
	 * Is ajax
	 *
	 * @return bool
	 */
	public function is_ajax(): bool {
		return ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) || defined( 'DOING_AJAX' );
	}

	/**
	 * Is rest
	 *
	 * @return bool
	 */
	public function is_rest(): bool {
		if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
			return true;
		}

		global $wp_rewrite;

		if ( null === $wp_rewrite ) {
			$wp_rewrite = new WP_Rewrite(); //phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		}

		$rest_url    = wp_parse_url( trailingslashit( rest_url() ) );
		$current_url = wp_parse_url( add_query_arg( array() ) );

		return strpos( $current_url['path'], substr( $rest_url['path'], 0, strlen( $rest_url['path'] ) - 1 ) ) === 0;
	}

	/**
	 * Is cron
	 *
	 * @return bool
	 */
	public function is_cron(): bool {
		return ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) || defined( 'DOING_CRON' );
	}

	/**
	 * Is frontend
	 *
	 * @return bool
	 */
	public function is_frontend(): bool {
		return ( ! $this->is_admin_backend() || ! $this->is_ajax() ) && ! $this->is_cron() && ! $this->is_rest();
	}

	/**
	 * Is cli
	 *
	 * @return bool
	 */
	public function is_cli(): bool {
		return defined( 'WP_CLI' ) && WP_CLI;
	}

	/**
	 * Is AMP
	 *
	 * @return bool
	 */
	public function is_amp(): bool {
		return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
	}

	/**
	 * Whether given user is an administrator.
	 *
	 * @param WP_User|null $user The given user.
	 *
	 * @return bool
	 */
	public static function is_user_admin( WP_User $user = null ): bool { //phpcs:ignore
		if ( is_null( $user ) ) {
			$user = wp_get_current_user();
		}

		if ( ! $user instanceof WP_User ) {
			_doing_it_wrong( __METHOD__, 'To check if the user is admin is required a WP_User object.', '1.0.0' );
		}

		return is_multisite() ? user_can( $user, 'manage_network' ) : user_can( $user, 'manage_options' );
	}

}
