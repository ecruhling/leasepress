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

//add_theme_support( 'resource-svg' );

/**
 * Get the settings of the plugin in a filterable way
 *
 * @return array
 */
function lp_get_settings() {
	return apply_filters( 'lp_get_settings', get_option( 'leasepress-settings' ) );
}

/**
 * Sanitizes an API Token, just to ensure everything is copacetic.
 *
 * Based on WordPress sanitize_title_with_dashes function, with some things removed in order to retain case.
 *
 * @param string $token The token to be sanitized.
 *
 * @return string The sanitized token.
 * @since 1.0
 */
function lp_sanitize_api_token( string $token ) {
	$token = wp_strip_all_tags( $token );
	// Preserve escaped octets.
	$token = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $token );
	// Remove percent signs that are not part of an octet.
	$token = str_replace( '%', '', $token );
	// Restore octets.
	$token = preg_replace( '|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $token );

	$token = preg_replace( '/&.+?;/', '', $token ); // kill entities.
	$token = str_replace( '.', '-', $token );

	$token = preg_replace( '/\s+/', '-', $token );
	$token = preg_replace( '|-+|', '-', $token );
	$token = trim( $token, '-' );

	return $token;
}
