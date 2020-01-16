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
 * This class contain the activate and deactivate method and relations.
 */
class LP_Admin_ActDeact extends LP_Admin_Base {

	/**
	 * Initialize the Act/Deact
	 *
	 * @return void
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
            return;
		}

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		register_activation_hook( LP_TEXTDOMAIN . '/' . LP_TEXTDOMAIN . '.php', array( __CLASS__, 'activate' ) );
		register_deactivation_hook( LP_TEXTDOMAIN . '/' . LP_TEXTDOMAIN . '.php', array( __CLASS__, 'deactivate' ) );
		add_action( 'admin_init', array( $this, 'upgrade_procedure' ) );
	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @param integer $blog_id ID of the new blog.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function activate_new_site( $blog_id ) {
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
	 * @param boolean $network_wide True if active in a multisite, false if classic site.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function activate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids
				$blogs = get_sites();
				foreach ( $blogs as $blog ) {
					switch_to_blog( $blog->blog_id );
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
	 * @param boolean $network_wide True if WPMU superadmin uses
	 *                              "Network Deactivate" action, false if
	 *                              WPMU is disabled or plugin is
	 *                              deactivated on an individual blog.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function deactivate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids
				$blogs = get_sites();
				foreach ( $blogs as $blog ) {
					switch_to_blog( $blog->blog_id );
					self::single_deactivate();
					restore_current_blog();
				}

				return;
			}
		}

		self::single_deactivate();
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
		// add_role( 'advanced', __( 'Advanced' ) ); //Add a custom roles
		self::add_capabilities();
		self::upgrade_procedure();
		// Clear the permalinks
		flush_rewrite_rules();
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
		// Clear the permalinks
		flush_rewrite_rules();
	}

	/**
	 * Add admin capabilities
	 *
	 * @return void
	 */
	public static function add_capabilities() {
		// Add the capabilities to all the roles
		$caps  = array(
			'create_plugins',
			'read_demo',
			'read_private_demoes',
			'edit_demo',
			'edit_demoes',
			'edit_private_demoes',
			'edit_published_demoes',
			'edit_others_demoes',
			'publish_demoes',
			'delete_demo',
			'delete_demoes',
			'delete_private_demoes',
			'delete_published_demoes',
			'delete_others_demoes',
			'manage_demoes',
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
				$role->add_cap( $cap );
			}
		}

		// Remove capabilities to specific roles
		$bad_caps = array(
			'create_demoes',
			'read_private_demoes',
			'edit_demo',
			'edit_demoes',
			'edit_private_demoes',
			'edit_published_demoes',
			'edit_others_demoes',
			'publish_demoes',
			'delete_demo',
			'delete_demoes',
			'delete_private_demoes',
			'delete_published_demoes',
			'delete_others_demoes',
			'manage_demoes',
		);
		$roles    = array(
			get_role( 'author' ),
			get_role( 'contributor' ),
			get_role( 'subscriber' ),
		);
		foreach ( $roles as $role ) {
			foreach ( $bad_caps as $cap ) {
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
		if ( is_admin() ) {
			$version = get_option( 'leasepress-version' );
			if ( version_compare( LP_VERSION, $version, '>' ) ) {
				update_option( 'leasepress-version', LP_VERSION );
				delete_option( LP_TEXTDOMAIN . '_fake-meta' );
			}
		}
	}

}
