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
use WP_Error;
use function __;
use function add_action;
use function admin_url;
use function current_user_can;
use function end;
use function esc_html__;
use function explode;
use function get_object_vars;
use function get_option;
use function gmdate;
use function header;
use function ignore_user_abort;
use function json_decode;
use function nocache_headers;
use function sanitize_text_field;
use function update_option;
use function wp_die;
use function wp_json_encode;
use function wp_safe_redirect;
use function wp_unslash;
use function wp_verify_nonce;

/**
 * Provide Import and Export of the settings of the plugin
 */
class ImpExp extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}

		// Add the export settings method.
		add_action( 'admin_init', array( $this, 'settings_export' ) );
		// Add the import settings method.
		add_action( 'admin_init', array( $this, 'settings_import' ) );
	}

	/**
	 * Process a settings export from config
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function settings_export() {
		if (
			empty( $_POST['lp_action'] ) ||
			'export_settings' !== sanitize_text_field( wp_unslash( $_POST['lp_action'] ) )
		) {
			return;
		}

		if ( ! empty( $_POST['lp_export_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lp_export_nonce'] ) ), 'lp_export_nonce' ) ) {
				return;
			}
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$settings    = array();
		$settings[0] = get_option( 'leasepress-settings' );
		$settings[1] = get_option( 'leasepress-settings-second' );

		ignore_user_abort( true );

		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=LeasePress-settings-export-' . gmdate( 'm-d-Y' ) . '.json' );
		header( 'Expires: 0' );

		echo wp_json_encode( $settings, JSON_PRETTY_PRINT );

		exit;
	}

	/**
	 * Process a settings import from a json file
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function settings_import() {
		if (
			empty( $_POST['lp_action'] ) ||
			'import_settings' !== sanitize_text_field( wp_unslash( $_POST['lp_action'] ) )
		) {
			return;
		}

		if ( ! empty( $_POST['lp_import_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lp_import_nonce'] ) ), 'lp_import_nonce' ) ) {
				return;
			}
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$file_name_parts = ! empty( $_FILES['lp_import_file']['name'] ) ? explode( '.', sanitize_text_field( wp_unslash( $_FILES['lp_import_file']['name'] ) ) ) : null;
		$extension       = end( $file_name_parts );

		if ( 'json' !== $extension ) {
			wp_die( esc_html__( 'Please upload a valid .json file', 'leasepress' ) );
		}

		$import_file = ! empty( $_FILES['lp_import_file']['tmp_name'] ) ? sanitize_text_field( wp_unslash( $_FILES['lp_import_file']['tmp_name'] ) ) : null;

		if ( empty( $import_file ) ) {
			wp_die( esc_html__( 'Please upload a file to import', 'leasepress' ) );
		}

		// Retrieve the settings from the file and convert the json object to an array.
		$settings_file = wp_remote_get( $import_file );

		if ( ! $settings_file ) {
			$settings = json_decode( (string) $settings_file );

			update_option( 'leasepress-settings', get_object_vars( $settings[0] ) );
			update_option( 'leasepress-settings-second', get_object_vars( $settings[1] ) );

			wp_safe_redirect( admin_url( 'options-general.php?page=leasepress' ) );
			exit;
		}

		new WP_Error(
			'LeasePress_import_settings_failed',
			__( 'Failed to import the settings.', 'leasepress' )
		);

	}

}
