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

namespace LeasePress\Backend;

use LeasePress\Engine\Base;
use function add_action;
use function delete_option;
use function did_action;
use function flush_rewrite_rules;
use function function_exists;
use function get_option;
use function get_role;
use function get_sites;
use function is_admin;
use function is_multisite;
use function is_null;
use function register_activation_hook;
use function register_deactivation_hook;
use function restore_current_blog;
use function switch_to_blog;
use function update_option;
use function version_compare;

/**
 * Activate and deactivate methods of the plugin.
 */
class ActDeact extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}

		// Activate plugin when a new site is added.
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		register_activation_hook( 'leasepress/leasepress.php', array( self::class, 'activate' ) );
		register_deactivation_hook( 'leasepress/leasepress.php', array( self::class, 'deactivate' ) );
		add_action( 'admin_init', array( $this, 'upgrade_procedure' ) );
	}

	/**
	 * Fired when a new site is activated within a WPMU environment.
	 *
	 * @param int $blog_id ID of the new blog.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function activate_new_site( int $blog_id ) {
		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param bool $network_wide True if active in a multisite, false if classic site.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function activate( bool $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids.
				$blogs = get_sites();

				foreach ( $blogs as $blog ) {
					switch_to_blog( (int) $blog->blog_id );
					self::single_activate();
					restore_current_blog();
				}

				return;
			}
		}

		self::single_activate();
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param bool $network_wide True if WPMU superadmin uses
	 * "Network Deactivate" action, false if
	 * WPMU is disabled or plugin is
	 * deactivated on an individual blog.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function deactivate( bool $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids.
				$blogs = get_sites();

				foreach ( $blogs as $blog ) {
					switch_to_blog( (int) $blog->blog_id );
					self::single_deactivate();
					restore_current_blog();
				}

				return;
			}
		}

		self::single_deactivate();
	}

	/**
	 * Add admin capabilities
	 *
	 * @return void
	 */
	public static function add_capabilities() {
		// Add the capabilities to all the roles.
		$caps  = array(
			'create_plugins',
			'read_demo',
			'read_private_demos',
			'edit_demo',
			'edit_demos',
			'edit_private_demos',
			'edit_published_demos',
			'edit_others_demos',
			'publish_demos',
			'delete_demo',
			'delete_demos',
			'delete_private_demos',
			'delete_published_demos',
			'delete_others_demos',
			'manage_demos',
		);
		$roles = array(
			get_role( 'administrator' ),
			get_role( 'editor' ),
			get_role( 'author' ),
			get_role( 'contributor' ),
			get_role( 'subscriber' ),
		);

		foreach ( $roles as $role ) {
			foreach ( $caps as $cap ) {
				if ( is_null( $role ) ) {
					continue;
				}

				$role->add_cap( $cap );
			}
		}

		// Remove capabilities to specific roles.
		$bad_caps = array(
			'create_demos',
			'read_private_demos',
			'edit_demo',
			'edit_demos',
			'edit_private_demos',
			'edit_published_demos',
			'edit_others_demos',
			'publish_demos',
			'delete_demo',
			'delete_demos',
			'delete_private_demos',
			'delete_published_demos',
			'delete_others_demos',
			'manage_demos',
		);
		$roles    = array(
			get_role( 'author' ),
			get_role( 'contributor' ),
			get_role( 'subscriber' ),
		);

		foreach ( $roles as $role ) {
			foreach ( $bad_caps as $cap ) {
				if ( is_null( $role ) ) {
					continue;
				}

				$role->remove_cap( $cap );
			}
		}
	}

	/**
	 * Upgrade procedure
	 *
	 * @return void
	 */
	public static function upgrade_procedure() {
		if ( ! is_admin() ) {
			return;
		}

		$version = get_option( 'plugin-name-version' );

		if ( ! version_compare( LP_VERSION, $version, '>' ) ) {
			return;
		}

		update_option( 'plugin-name-version', LP_VERSION );
		delete_option( 'leasepress_fake-meta' );
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
		// add_role( 'advanced', __( 'Advanced' ) ); //Add a custom roles
		self::add_capabilities();
		self::upgrade_procedure();
		// Clear the permalinks.
		flush_rewrite_rules();
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
		// Clear the permalinks
		flush_rewrite_rules();
	}

}
