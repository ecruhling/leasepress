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
 * This class contain the Enqueue stuff for the backend
 */
class LP_Admin_Settings_Page extends LP_Admin_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
			return;
		}

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . 'leasepress.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_plugin_admin_menu() {
		/*
		 * Add a settings page for this plugin to the main menu
		 *
		 */
		add_menu_page( __( 'LeasePress Settings', 'leasepress' ), LP_NAME, 'manage_options', 'leasepress', array( $this, 'display_plugin_admin_page' ), 'dashicons-grid-view', 80 );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_plugin_admin_page() {
		include_once( LP_PLUGIN_ROOT . 'admin/views/admin.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since 1.0.0
	 *
	 * @param array $links Array of links.
	 *
	 * @return array
	 */
	public function add_action_links( $links ) {
		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . 'leasepress' ) . '">' . __( 'Settings', 'leasepress' ) . '</a>',
			),
            $links
		);
	}

}
