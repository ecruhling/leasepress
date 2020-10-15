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
 * Provide Import and Export of the settings of the plugin
 */
class LP_Admin_ImpExp extends LP_Admin_Base {

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
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
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function settings_export() {
		$lp_action       = isset( $_POST['lp_action'] ) ? sanitize_text_field( wp_unslash( $_POST['lp_action'] ) ) : null;
		$lp_export_nonce = isset( $_POST['lp_export_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['lp_export_nonce'] ) ) : null;

		if ( empty( $lp_action ) || 'export_settings' !== $lp_action ) {
			return;
		}

		if ( ! wp_verify_nonce( $lp_export_nonce, 'lp_export_nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$settings[0] = get_option( 'leasepress-settings' );
		$settings[1] = get_option( 'leasepress-settings-second' );

		ignore_user_abort( true );

		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=leasepress-settings-export-' . gmdate( 'm-d-Y' ) . '.json' );
		header( 'Expires: 0' );

		echo wp_json_encode( $settings, JSON_PRETTY_PRINT );

		exit;
	}

	/**
	 * Process a settings import from a json file
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function settings_import() {
		$lp_action        = isset( $_POST['lp_action'] ) ? sanitize_text_field( wp_unslash( $_POST['lp_action'] ) ) : null;
		$lp_import_nonce  = isset( $_POST['lp_import_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['lp_import_nonce'] ) ) : null;
		$import_file_name = isset( $_FILES['import_file']['name'] ) ? sanitize_text_field( wp_unslash( $_FILES['import_file']['name'] ) ) : null;
		$import_file      = isset( $_FILES['import_file']['tmp_name'] ) ? sanitize_text_field( wp_unslash( $_FILES['import_file']['tmp_name'] ) ) : null;

		if ( empty( $lp_action ) || 'import_settings' !== $lp_action ) {
			return;
		}

		if ( ! wp_verify_nonce( $lp_import_nonce, 'lp_import_nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$array     = explode( '.', $import_file_name );
		$extension = end( $array );

		if ( 'json' !== $extension ) {
			wp_die( esc_html__( 'Please upload a valid .json file', 'leasepress' ) );
		}

		if ( empty( $import_file ) ) {
			wp_die( esc_html__( 'Please upload a file to import', 'leasepress' ) );
		}

		// Retrieve the settings from the file and convert the json object to an array.
		$settings = (array) json_decode( wp_remote_get( $import_file ) );

		update_option( 'leasepress-settings', get_object_vars( $settings[0] ) );
		update_option( 'leasepress-settings-second', get_object_vars( $settings[1] ) );

		wp_safe_redirect( admin_url( 'options-general.php?page=leasepress' ) );
		exit;
	}

}
