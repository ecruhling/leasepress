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

$lp_debug = new WPBP_Debug( __( 'LeasePress', 'leasepress' ) );

/**
 * Log text inside the debugging plugins.
 *
 * @param string $text The text to add to the debug log.
 *
 * @return void
 * @noinspection PhpUnused
 */
function lp_log( string $text ) {
	global $lp_debug;
	$lp_debug->log( $text );
}
