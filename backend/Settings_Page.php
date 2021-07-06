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
use function __;
use function add_action;
use function add_filter;
use function add_menu_page;
use function admin_url;
use function array_merge;
use function dirname;
use function plugin_basename;
use function plugin_dir_path;
use function realpath;

/**
 * Create the settings page in the backend
 */
class Settings_Page extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		$realpath        = (string) realpath( dirname( __FILE__ ) );
		$plugin_basename = plugin_basename( plugin_dir_path( $realpath ) . 'leasepress.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function add_plugin_admin_menu() {
		/*
		 * Add a settings page for this plugin to the main menu
		 *
		 */
		add_menu_page(
			__( 'LeasePress Settings', 'leasepress' ),
			LP_NAME,
			'manage_options',
			'leasepress',
			array(
				$this,
				'display_plugin_admin_page',
			),
			'dashicons-grid-view',
			80,
		);
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once LP_PLUGIN_ROOT . 'backend/views/admin.php';
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @param array $links Array of links.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function add_action_links( array $links ): array {
		return array_merge(
			array(
				'settings' => '<a title="LeasePress settings" href="' . admin_url( 'options-general.php?page=leasepress' ) . '">' . __( 'Settings', 'leasepress' ) . '</a>',
			),
			$links
		);
	}

}
