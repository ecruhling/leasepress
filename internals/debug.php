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

function lp_log( $text ) {
	global $lp_debug;
	$lp_debug->log( $text );
}

