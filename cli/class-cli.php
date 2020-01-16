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

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    /**
     * This class contain the WP CLI support
     */
    class L_WPCli extends L_Base {

        public function initialize() {
            if ( !apply_filters( 'leasepress_l_enqueue_admin_initialize', true ) ) {
                return;
            }

            parent::initialize();
		}

        /**
         * Initialize the commands
         *
         * @return void
         */
        public function __construct() {
            WP_CLI::add_command( 'l_commandname', array( $this, 'command_example' ) );
        }

        /**
         * Example command
		 * API reference: https://wp-cli.org/docs/internal-api/
		 *
		 * @param array $args The attributes.
		 *
		 * @return void
		 */
		public function command_example( $args ) {
			// Message prefixed with "Success: ".
			WP_CLI::success( $args[0] );
			// Message prefixed with "Warning: ".
			WP_CLI::warning( $args[0] );
			// Message prefixed with "Debug: ". when '--debug' is used
			WP_CLI::debug( $args[0] );
			// Message prefixed with "Error: ".
			WP_CLI::error( $args[0] );
			// Message with no prefix
			WP_CLI::log( $args[0] );
			// Colorize a string for output
			WP_CLI::colorize( $args[0] );
			// Halt script execution with a specific return code
			WP_CLI::halt( $args[0] );
		}

	}

}
