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
 * LeasePress Is Methods
 */
class LP_Is_Methods {

	/**
	 * Whether given user is an administrator.
	 *
	 * @param WP_User $user The given user.
	 * @return bool
	 */
	public static function is_user_admin( WP_User $user = NULL ) {
		if ( is_null( $user ) ) {
			$user = wp_get_current_user();
		}

		if ( ! $user instanceof WP_User ) {
			_doing_it_wrong( __METHOD__, 'To check if the user is admin is required a WP_User object.', '1.0.0' );
		}

		return is_multisite() ? user_can( $user, 'manage_network' ) : user_can( $user, 'manage_options' );
	}

	/**
	 * What type of request is this?
	 *
	 * @since 1.0.0
	 *
	 * @param  string $type admin, ajax, cron, cli or frontend.
	 * @return bool
	 */
	public function request( $type ) {
		switch ( $type ) {
			case 'admin_backend':
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
			default:
				_doing_it_wrong( __METHOD__, esc_html( sprintf( 'Unknown request type: %s', $type ) ), '1.0.0' );
				return false;
		}
	}

	/**
	 * Is installing WP
	 *
	 * @return boolean
	 */
	public function is_installing_wp() {
		return defined( 'WP_INSTALLING' );
	}

	/**
	 * Is admin
	 *
	 * @return boolean
	 */
	public function is_admin_backend() {
		return is_user_logged_in() && is_admin();
	}

	/**
	 * Is ajax
	 *
	 * @return boolean
	 */
	public function is_ajax() {
		return ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) || defined( 'DOING_AJAX' );
	}

	/**
	 * Is rest
	 *
	 * @return boolean
	 */
	public function is_rest() {
		return defined( 'REST_REQUEST' );
	}

	/**
	 * Is cron
	 *
	 * @return boolean
	 */
	public function is_cron() {
		return ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) || defined( 'DOING_CRON' );
	}

	/**
	 * Is frontend
	 *
	 * @return boolean
	 */
	public function is_frontend() {
		return ( ! $this->is_admin_backend() || ! $this->is_ajax() ) && ! $this->is_cron() && ! $this->is_rest();
	}

	/**
	 * Is cli
	 *
	 * @return boolean
	 */
	public function is_cli() {
		return defined( 'WP_CLI' ) && WP_CLI;
	}

}
